<?php

namespace App\Http\Controllers\Tecnica\ObrasElectricas;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\EmailTrait;
use App\Services\EmailService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Tecnica\ObrasElectricas\Solicitud;
use App\Models\Tecnica\ObrasElectricas\Presupuesto;
use App\Models\Tecnica\ObrasElectricas\Observacion;
use App\Models\Tecnica\ObrasElectricas\SolicitudPresupuesto;
use App\Models\Tecnica\ObrasElectricas\SolicitudObservacion;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PresupuestoController extends Controller
{
    use EmailTrait;

    public function __construct(EmailService $emailService)
    {
        $this->bootEmail($emailService);
    }

    public function index()
    {
        $archivosConDatos = [];
        $pathPresupuestos = env('NAS_PATH_PRESUPUESTOS');
        if (!File::exists($pathPresupuestos)) {
            return back()->with('error', 'La carpeta de presupuestos no existe.');
        }
        // Obtener la lista de archivos en el NAS
        $archivos = array_diff(scandir($pathPresupuestos), ['.', '..']);

        // Obtener los últimos presupuestos por solicitud
        $ultimosPresupuestos = SolicitudPresupuesto::selectRaw('MAX(SPR_ID) as SPR_ID')
            ->groupBy('SPR_SOLICITUD_ID')
            ->pluck('SPR_ID');

        $presupuestos = SolicitudPresupuesto::whereIn('SPR_ID', $ultimosPresupuestos)->get();

        foreach ($presupuestos as $ultimoPresupuesto) {
            $presupuesto = $ultimoPresupuesto->presupuesto;
            if (!$presupuesto) {
                continue;
            }
            // Verificar si el archivo correspondiente está en el NAS
            $archivoNombre = basename($presupuesto->PSO_PATH);
            if (!in_array($archivoNombre, $archivos)) {
                continue;
            }
            // Obtener la solicitud asociada
            $solicitud = $ultimoPresupuesto->solicitud;
            $archivosConDatos[] = [
                'archivo' => $archivoNombre,
                'nombre' => $solicitud->SOE_NOMBRE ?? 'Desconocido',
                'apellido' => $solicitud->SOE_APELLIDO ?? 'Desconocido',
                'calle' => $solicitud->SOE_CALLE ?? 'Desconocido',
                'ultimo_presupuesto' => $presupuesto->PSO_PATH,
            ];
        }

        return view('tecnica.obrasElectricas.presupuestos.index', compact('archivosConDatos'));
    }

    public function create(Solicitud $solicitud)
    {
        $solicitud->load('tipos', 'localidad');
        return view('tecnica.obrasElectricas.presupuestos.create', compact('solicitud'));
    }

    public function store(Request $request)
    {
        $path = $this->obtenerRutaPresupuesto($request->input('nombre'));

        DB::connection('ALUM')->transaction(function () use ($request, $path) {
            $solicitud = Solicitud::with('ultimoEstado')->findOrFail($request->input('solicitud'));

            $presupuesto = Presupuesto::create(array_merge(
                ['PSO_PATH' => $path],
                $this->estadoNotifica($request->input('emailNotificar'))
            ));
            if ($request->filled('subestacion')) {
                $this->actualizarSolicitud($solicitud, ['SOE_SUBESTACION' => $request->subestacion]);
            }

            $this->crearEstado($solicitud, 6); // Estado "Presupuestada"

            SolicitudPresupuesto::create([
                'SPR_SOLICITUD_ID' => $solicitud->SOE_ID,
                'SPR_PRESUPUESTO_ID' => $presupuesto->PSO_ID,
                'SPR_USUARIO' => trim(Auth::user()->USU_CODIGO),
                'SPR_FECHA' => Carbon::now(),
            ]);

            if ($request->input('emailNotificar')) {
                $this->enviarEmail($request, $solicitud, $path);
            }
        });

        return redirect()->route('solicitudes')->with('status', 'Solicitud procesada correctamente.');
    }

    public function show(string $nombreArchivo)
    {
        $presupuesto = env('NAS_PATH_PRESUPUESTOS') . $nombreArchivo;
        if (!File::exists($presupuesto)) {
            abort(404, "Archivo no encontrado");
        }

        return response()->file($presupuesto);
    }

    public function update(Request $request, string $id)
    {
        DB::connection('ALUM')->transaction(function () use ($request, $id) {
            $solicitud = Solicitud::with('ultimoPresupuesto')->findOrFail($id);

            if ($request->filled('nroAsociado')) {
                $this->actualizarSolicitud($solicitud, ['SOE_ASOCIADO' => $request->nroAsociado]);
            }

            if ($request->filled('nroSuministro')) {
                $this->actualizarSolicitud($solicitud, ['SOE_SUMINISTRO' => $request->nroSuministro]);
            }

            $nuevoEstado = $this->crearEstado($solicitud, $request->accion === 'aceptar' ? 1 : 3); // 1: Aceptada, 3: Cerrada

            if ($request->filled('observacion')) {
                $this->crearObservacion($nuevoEstado, $request->observacion);
            }

            $this->actualizarPresupuesto($solicitud);

            $this->actualizarPresupuestosDirectos($solicitud, $request->accion === 'aceptar');
        });

        return redirect()->route('solicitudes')->with('status', 'Solicitud procesada correctamente.');
    }

    public function notificarEmail(Request $request, $id)
    {
        $solicitud = Solicitud::findOrFail($id);
        $presupuesto = $solicitud->presupuestosDirectos()
            ->orderByDesc('ALUM.dbo.SOLICITUD_PRESUPUESTO.SPR_FECHA')
            ->first();
        if (!$presupuesto) {
            return redirect()->back()->with('error', 'No se encontró un presupuesto para esta solicitud.');
        }

        try {
            DB::connection('ALUM')->transaction(function () use ($request, $solicitud, $presupuesto) {
                $presupuesto->increment('PSO_VECES');
                $presupuesto->PSO_USU_NOTIFICA = trim(Auth::user()->USU_CODIGO);
                $presupuesto->PSO_F_NOTIFICA = now();
                $presupuesto->save();

                $this->enviarEmail($request, $solicitud, $presupuesto->PSO_PATH);
            });

            return redirect()->back()->with('success', 'Correo enviado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Hubo un problema al enviar el correo: ' . $e->getMessage());
        }
    }

    public function abrirPresupuesto($solicitudId)
    {
        $solicitud = Solicitud::with(['ultimoPresupuesto.presupuesto'])->find($solicitudId);
        if (!$solicitud || !$solicitud->ultimoPresupuesto?->presupuesto?->PSO_PATH) {
            return $this->errorResponse("No se encontró la ruta en la base de datos para el presupuesto", 404);
        }

        $path = $this->convertirRuta($solicitud->ultimoPresupuesto->presupuesto->PSO_PATH);
        if (!$this->validarArchivo($path)) {
            return $this->errorResponse("El archivo no es accesible en la ruta: $path", 404);
        }

        return Response::file($path);
    }

    // Métodos auxiliares
    private function obtenerRutaPresupuesto($nombre)
    {
        $rutaRed = env('NAS_PATH_PRESUPUESTOS');
        $rutaUnidad = str_replace('\\\\172.16.14.27\\atp - tecnica', 'P:', $rutaRed);

        return rtrim($rutaUnidad, '\\') . '\\' . $nombre;
    }

    private function estadoNotifica($emailNotificar)
    {
        return $emailNotificar ? [
            'PSO_NOTIFICA' => 'S',
            'PSO_VECES' => 1,
            'PSO_USU_NOTIFICA' => trim(Auth::user()->USU_CODIGO),
            'PSO_F_NOTIFICA' => Carbon::now(),
        ] : [
            'PSO_NOTIFICA' => 'N',
            'PSO_VECES' => null,
            'PSO_USU_NOTIFICA' => null,
            'PSO_F_NOTIFICA' => null,
        ];
    }

    private function actualizarSolicitud($solicitud, array $datos)
    {
        $solicitud->update(array_merge($datos, [
            'SOE_USUARIO' => trim(Auth::user()->USU_CODIGO),
            'SOE_UPDATE' => Carbon::now(),
        ]));
    }

    private function crearEstado($solicitud, $estadoId)
    {
        return $solicitud->estados()->create([
            'SES_ESTADO_ID' => $estadoId,
            'SES_USUARIO' => trim(Auth::user()->USU_CODIGO),
            'SES_FECHA' => Carbon::now(),
        ]);
    }

    private function crearObservacion($estado, $descripcion)
    {
        if (!$descripcion) return;

        $observacion = Observacion::create(['OSO_DESCRIPCION' => $descripcion]);

        SolicitudObservacion::create([
            'SOB_SES_ID' => $estado->SES_ID,
            'SOB_OBSERVACION_ID' => $observacion->OSO_ID,
            'SOB_USUARIO' => trim(Auth::user()->USU_CODIGO),
            'SOB_FECHA' => Carbon::now(),
        ]);
    }

    private function actualizarPresupuesto($solicitud)
    {
        if ($solicitud->ultimoPresupuesto) {
            $solicitud->ultimoPresupuesto->update([
                'SPR_USUARIO' => trim(Auth::user()->USU_CODIGO),
                'SPR_FECHA' => Carbon::now(),
            ]);
        }
    }

    private function actualizarPresupuestosDirectos($solicitud, $aceptado)
    {
        $solicitud->presupuestosDirectos()->update([
            'PSO_ACEPTA' => $aceptado ? 'S' : 'N',
            'PSO_USU_ACEPTA' => trim(Auth::user()->USU_CODIGO),
            'PSO_F_ACEPTA' => Carbon::now(),
        ]);
    }

    private function convertirRuta($path)
    {
        return Str::startsWith($path, 'P:')
            ? str_replace('P:', env('NAS_PATH_DOCUMENTOS'), $path)
            : $path;
    }

    private function validarArchivo($path)
    {
        return is_file($path) && is_readable($path);
    }

    private function errorResponse($mensaje, $codigo)
    {
        throw new HttpException($codigo, $mensaje);
    }
}

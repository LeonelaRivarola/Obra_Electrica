<?php

namespace App\Http\Controllers\Tecnica\ObrasElectricas;

use Carbon\Carbon;
use App\Models\Localidad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSolicitudRequest;
use App\Http\Requests\UpdateSolicitudRequest;
use App\Models\Tecnica\ObrasElectricas\Estado;
use App\Models\Tecnica\ObrasElectricas\TipoObra;
use App\Models\Tecnica\ObrasElectricas\Solicitud;
use App\Models\Tecnica\ObrasElectricas\Observacion;
use App\Models\Tecnica\ObrasElectricas\SolicitudObservacion;
use App\Traits\EmailTrait;
use App\Services\EmailService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Log;

class SolicitudController extends Controller
{
    use EmailTrait;

    public function __construct(EmailService $emailService)
    {
        $this->bootEmail($emailService);
    }

    public function index(Request $request)
    {
        $estadoId = $request->get('estado');

        $solicitudes = Solicitud::with(['tipos', 'localidad', 'ultimoEstado.estado'])
            ->when($estadoId, function ($query) use ($estadoId) {
                $query->whereHas('ultimoEstado', function ($subQuery) use ($estadoId) {
                    $subQuery->where('SES_ESTADO_ID', $estadoId)
                        ->whereRaw('SES_FECHA = (
                             SELECT MAX(SES_FECHA)
                             FROM ALUM.dbo.SOLICITUD_ESTADO
                             WHERE SES_SOLICITUD_ID = SOLICITUD_OBRA_ELECTRICA.SOE_ID
                         )');
                });
            })
            ->orderBy('SOE_FECHA', 'desc')
            ->paginate(20);

        $estados = Estado::all();

        return view('tecnica.obrasElectricas.solicitudes.index', compact('solicitudes', 'estados'));
    }

    public function create()
    {
        $localidades = Localidad::on('GeaCorpico')
            ->where('LOC_SUCURSAL', 1)
            ->select('LOC_ID', 'LOC_DESCRIPCION')
            ->get();

        $tipos = TipoObra::all();

        return view('tecnica.obrasElectricas.solicitudes.create', compact('localidades', 'tipos'));
    }

    public function store(StoreSolicitudRequest $request)
    {
        $solicitud = Solicitud::create([
            'SOE_CUIT' => $request->input('cuit'),
            'SOE_APELLIDO' => $request->input('apellido'),
            'SOE_NOMBRE' => $request->input('nombre'),
            'SOE_CALLE' => $request->input('calle'),
            'SOE_ALTURA' => $request->input('altura'),
            'SOE_PISO' => $request->input('piso'),
            'SOE_DPTO' => $request->input('dpto'),
            'SOE_LOCALIDAD_ID' => $request->input('localidad'),
            'SOE_CELULAR' => $request->input('celular'),
            'SOE_EMAIL' => $request->input('email'),
            'SOE_TIPO_ID' => $request->input('tipo'),
            'SOE_USUARIO' => trim(Auth::user()->USU_CODIGO),
            'SOE_FECHA' => Carbon::now(),
            'SOE_UPDATE' => Carbon::now(),
        ]);

        $tipo = TipoObra::find($request->input('tipo'));

        $solicitud->estados()->create([
            'SES_ESTADO_ID' => ($request->input('cuit') == '30545719386' && $tipo->TOE_INTERNO == 'S') ? 5 : 4,  // Estado 5: "Pendiente", Estado 4: "iniciada"
            'SES_USUARIO' => trim(Auth::user()->USU_CODIGO),
            'SES_FECHA' => Carbon::now(),
        ]);

        return redirect()->route('solicitudes')->with('status', 'Solicitud creada correctamente.');
    }

    public function show(Solicitud $solicitud)
    {
        $solicitud->load(
            'tipos',
            'localidad',
            'ultimoEstado.estado',
            'ultimoEstado.ultimaObservacion.observacion',
            'ultimoPresupuesto.presupuesto',
        );

        return view('tecnica.obrasElectricas.solicitudes.show', compact('solicitud'));
    }

    public function abrirSolicitud($id)
    {
        $path = Solicitud::where('SOE_ID', $id)->value('SOE_PATH');

        if (!$path) {
            return $this->errorResponse("No se encontró la ruta en la base de datos para la solicitud ID: $id", 404);
        }

        $path = $this->convertirRuta($path);
        if (!$this->archivoValido($path)) {
            return $this->errorResponse("El archivo no es accesible en la ruta: $path", 404);
        }

        return Response::file($path);
    }

    public function edit(Solicitud $solicitud)
    {
        $localidades = Localidad::on('GeaCorpico')
            ->where('LOC_SUCURSAL', 1)
            ->select('LOC_ID', 'LOC_DESCRIPCION')
            ->get();

        $tipos = TipoObra::all();

        return view('tecnica.obrasElectricas.solicitudes.edit', compact('solicitud', 'localidades', 'tipos'));
    }

    public function accredit(Solicitud $solicitud)
    {
        $solicitud->load('tipos', 'localidad');
        return view('tecnica.obrasElectricas..solicitudes.accredit', compact('solicitud'));
    }

    public function update(UpdateSolicitudRequest $request, Solicitud $solicitud)
    {
        $data = ['SOE_USUARIO' => trim(Auth::user()->USU_CODIGO), 'SOE_UPDATE' => Carbon::now(),];
        if ($request->filled('cuit')) {
            $data['SOE_CUIT'] = $request->input('cuit');
        }
        if ($request->filled('apellido')) {
            $data['SOE_APELLIDO'] = $request->input('apellido');
        }
        if ($request->filled('nombre')) {
            $data['SOE_NOMBRE'] = $request->input('nombre');
        }
        if ($request->filled('calle')) {
            $data['SOE_CALLE'] = $request->input('calle');
        }
        if ($request->filled('altura')) {
            $data['SOE_ALTURA'] = $request->input('altura');
        }
        if ($request->filled('piso')) {
            $data['SOE_PISO'] = $request->input('piso');
        }
        if ($request->filled('dpto')) {
            $data['SOE_DPTO'] = $request->input('dpto');
        }
        if ($request->filled('localidad')) {
            $data['SOE_LOCALIDAD_ID'] = $request->input('localidad');
        }
        if ($request->filled('celular')) {
            $data['SOE_CELULAR'] = $request->input('celular');
        }
        if ($request->filled('email')) {
            $data['SOE_EMAIL'] = $request->input('email');
        }
        if ($request->filled('tipo')) {
            $data['SOE_TIPO_ID'] = $request->input('tipo');
        }
        if ($request->filled('subestacion')) {
            $data['SOE_SUBESTACION'] = $request->input('subestacion');
        }
        if ($request->filled('asociado')) {
            $data['SOE_ASOCIADO'] = $request->input('asociado');
        }
        if ($request->filled('suministro')) {
            $data['SOE_SUMINISTROO'] = $request->input('suministro');
        }
        if ($request->filled('obra')) {
            $data['SOE_OBRA'] = $request->input('obra');
        }
        if ($request->filled('path')) {
            $data['SOE_PATH'] = $request->input('path');
        }
        $solicitud->update($data);

        return redirect()->route('solicitudes')->with('status', 'Solicitud Actualizada correctamente.');
    }

    public function path(Request $request)
    {
        $clarion = json_decode($request->getContent(), true);

        $solicitud = Solicitud::where('SOE_ID', $clarion['SOL:ID'])->first();
        if ($solicitud) {
            $data = [
                'SOE_USUARIO' => trim($clarion['SOL:USERNAME']),
                'SOE_UPDATE' => Carbon::now(),
                'SOE_PATH' => $clarion['SOL:PATH']
            ];
            $solicitud->update($data);

            $solicitud->estados()->create([
                'SES_ESTADO_ID' => 5, // Estado "Pendiente"
                'SES_USUARIO' => trim($clarion['SOL:USERNAME']),
                'SES_FECHA' => Carbon::now(),
            ]);

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Solicitud no encontrada'], 404);
        }
    }

    public function cancelar(Solicitud $solicitud, Request $request)
    {
        $observacion = Observacion::create([
            'OSO_DESCRIPCION' => $request->observacion,
        ]);
        $solicitud->update([
            'SOE_USUARIO' => trim(Auth::user()->USU_CODIGO),
            'SOE_UPDATE' => Carbon::now(),
        ]);
        $nuevoEstado = $solicitud->estados()->create([
            'SES_ESTADO_ID' => 3, // Estado "Cerrada"
            'SES_USUARIO' => trim(Auth::user()->USU_CODIGO),
            'SES_FECHA' => Carbon::now(),
        ]);
        SolicitudObservacion::create([
            'SOB_SES_ID' => $nuevoEstado->SES_ID,
            'SOB_OBSERVACION_ID' => $observacion->OSO_ID,
            'SOB_USUARIO' => trim(Auth::user()->USU_CODIGO),
            'SOB_FECHA' => Carbon::now(),
        ]);

        $this->enviarEmail($request, $solicitud);

        return redirect()->route('solicitudes')->with('status', 'Solicitud Cerrada correctamente!');
    }

    public function finalizar(Solicitud $solicitud, Request $request)
    {
        $solicitud->update([
            'SOE_USUARIO' => trim(Auth::user()->USU_CODIGO),
            'SOE_UPDATE' => Carbon::now(),
            'SOE_OBRA' => $request->valorObra
        ]);

        $solicitud->estados()->create([
            'SES_ESTADO_ID' => 3, // Estado "Cerrada"
            'SES_USUARIO' => trim(Auth::user()->USU_CODIGO),
            'SES_FECHA' => Carbon::now(),
        ]);

        return redirect()->route('solicitudes')->with('status', 'Solicitud Finalizada correctamente!');
    }

    public function destroy(Solicitud $solicitud)
    {
        $solicitud->delete();
        return redirect()->route('solicitudes')->with('status', 'Solicitud Eliminada correctamente!');
    }

    private function convertirRuta($path)
    {
        return Str::startsWith($path, 'P:')
            ? str_replace('P:', env('NAS_PATH_DOCUMENTOS'), $path)
            : $path;
    }

    private function archivoValido($path)
    {
        return is_file($path) && is_readable($path);
    }

    private function errorResponse($mensaje, $codigo)
    {
        Log::error($mensaje);
        throw new HttpException($codigo, $mensaje);
    }
}

<?php

namespace App\Http\Controllers\Tecnica\ObrasElectricas;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\EmailTrait;
use App\Services\EmailService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Tecnica\ObrasElectricas\Solicitud;
use App\Models\Tecnica\ObrasElectricas\Observacion;
use App\Models\Tecnica\ObrasElectricas\SolicitudObservacion;
use Illuminate\Support\Facades\Log;

class ObservacionController extends Controller
{
    use EmailTrait;

    public function __construct(EmailService $emailService)
    {
        $this->bootEmail($emailService);
    }

    public function create(Solicitud $solicitud)
    {
        $solicitud->load('tipos', 'localidad');
        return view('tecnica.obrasElectricas.observaciones.create', compact('solicitud'));
    }

    public function store(Request $request)
    {
        $solicitud = Solicitud::with('ultimoEstado')->findOrFail($request->input('soe_id'));
        $observacion = Observacion::create([
            'OSO_DESCRIPCION' => $request->input('observacion'),
        ]);
        $solicitud->update([
            'SOE_USUARIO' => trim(Auth::user()->USU_CODIGO),
            'SOE_UPDATE' => Carbon::now(),
        ]);
        SolicitudObservacion::create([
            'SOB_SES_ID' => $solicitud->ultimoEstado->SES_ID,
            'SOB_OBSERVACION_ID' => $observacion->OSO_ID,
            'SOB_USUARIO' => trim(Auth::user()->USU_CODIGO),
            'SOB_FECHA' => Carbon::now(),
        ]);

        if ($request->input('emailNotificar')) {
            $this->enviarEmail($request, $solicitud);
        }

        return redirect()->route('solicitudes')->with('status', 'Solicitud Observada correctamente.');
    }
}

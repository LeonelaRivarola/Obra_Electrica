<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Services\EmailService;
use App\Models\Tecnica\ObrasElectricas\EmailSolicitud;
use Illuminate\Support\Facades\Auth;

trait EmailTrait
{
    protected $emailService;

    /**
     * Método para inyectar el servicio de email.
     *
     * @param EmailService $emailService
     */
    public function bootEmail(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Envía un correo electrónico utilizando el EmailService y registra el envío en la base de datos.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed $solicitud    Objeto Solicitud (por ejemplo, con atributo SOE_ID)
     * @param string|null $emailAdjunto   (opcional) Ruta del archivo adjunto
     * @return bool
     */
    protected function enviarEmail($request, $solicitud, $emailAdjunto = null): bool
    {
        // Sin destino, no se envía el correo.
        if (!$request->has('emailDestino')) {
            return false;
        }

        $resultado = $this->emailService->enviarEmail(
            $request->input('emailDestino'),
            $request->input('emailOrigen'),
            $request->input('emailAsunto'),
            $request->input('emailMensaje'),
            $emailAdjunto ? str_replace('P:', env('NAS_PATH_DOCUMENTOS'), $emailAdjunto) : null
        );

        EmailSolicitud::create([
            'EMSO_SOLICITUD_ID' => $solicitud->SOE_ID,
            'EMSO_ORIGEN'       => $request->input('emailOrigen'),
            'EMSO_DESTINO'      => $request->input('emailDestino'),
            'EMSO_ASUNTO'       => $request->input('emailAsunto'),
            'EMSO_MENSAJE'      => $request->input('emailMensaje'),
            'EMSO_ADJUNTO'      => $emailAdjunto,
            'EMSO_USUARIO'      => Auth::check() ? trim(Auth::user()->USU_CODIGO) : 'sistema',
            'EMSO_FECHA'        => Carbon::now(),
        ]);

        return $resultado;
    }
}

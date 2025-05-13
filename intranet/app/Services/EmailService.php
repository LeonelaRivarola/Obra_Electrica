<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Mail\Email as EmailMailable;

class EmailService
{
    /**
     * Envía un correo electrónico.
     *
     * @param string $emailDestino
     * @param string $emailOrigen
     * @param string $emailAsunto
     * @param string $emailMensaje
     * @param string|null $emailAdjunto
     * @return bool
     */

    public function enviarEmail(
        string $emailDestino,
        string $emailOrigen,
        string $emailAsunto,
        string $emailMensaje,
        ?string $emailAdjunto = null
    ): bool {
        if (!$emailDestino) {
            return false;
        }

        try {
            Mail::to($emailDestino)
                ->send(new EmailMailable(
                    $emailOrigen,
                    $emailAsunto,
                    $emailMensaje,
                    $emailAdjunto
                ));
            return true;
        } catch (\Exception $e) {
            Log::error('Error al enviar el correo: ' . $e->getMessage());
            return false;
        }
    }
}

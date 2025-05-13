<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Email extends Mailable
{
    use Queueable, SerializesModels;

    public $emailOrigen;
    public $emailAsunto;
    public $emailMensaje;
    public $pathAdjunto;

    /**
     * Create a new message instance.
     */
    public function __construct($emailOrigen, $emailAsunto, $emailMensaje, $pathAdjunto = null)
    {
        $this->emailOrigen = $emailOrigen;
        $this->emailAsunto = $emailAsunto;
        $this->emailMensaje = $emailMensaje;
        $this->pathAdjunto = $pathAdjunto;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new \Illuminate\Mail\Mailables\Address($this->emailOrigen),
            subject: $this->emailAsunto,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.email',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    public function build()
    {
        // $email = $this->from($this->emailOrigen)
        //     ->subject($this->emailAsunto)
        //     ->html($this->emailMensaje);

        $email = $this->from($this->emailOrigen)
            ->subject($this->emailAsunto)
            ->markdown('emails.email')
            ->with([
                'emailMensaje' => $this->emailMensaje,
            ]);

        // Adjuntar archivo si el path está definido y el archivo existe
        if ($this->pathAdjunto && file_exists($this->pathAdjunto)) {
            $email->attach($this->pathAdjunto);
        }

        return $email;
    }
}

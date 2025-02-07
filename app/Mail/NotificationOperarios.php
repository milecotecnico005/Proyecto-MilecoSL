<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class NotificationOperarios extends Mailable
{
    use Queueable, SerializesModels;

    public $userName; // El nombre del usuario para el subject
    public $content;  // El contenido del email (texto, datos, etc.)
    public $imagePaths; // Lista de rutas de las imágenes a adjuntar

    /**
     * Create a new message instance.
     *
     * @param string $userName El nombre del usuario
     * @param mixed $content Contenido del email
     * @param array $imagePaths Rutas de las imágenes a adjuntar
     */
    public function __construct($userName, $content, $imagePaths = [])
    {
        $this->userName = $userName;
        $this->content = $content;
        $this->imagePaths = $imagePaths;

        // Establecer el subject dinámico
        $this->subject("Orden de Trabajo para $userName");
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.notificationOperarios',
            with: [
                'userName' => $this->userName,
                'otherData' => $this->content,
                'imagePaths' => $this->imagePaths,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        // Adjuntar imágenes si las hay
        foreach ($this->imagePaths as $path) {
            $attachments[] = Attachment::fromPath($path);
        }

        return $attachments;
    }
}


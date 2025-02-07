<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Modelo347 extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $data;
    public $path;
    public $archivo;

    /**
     * Create a new message instance.
     */
    public function __construct($subject, $data, $path, $archivo)
    {
        $this->subject = $subject;
        $this->data = $data;
        $this->path = $path;
        $this->archivo = $archivo;
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
    public function build()
    {
        return $this->view('emails.modelo347')
                    ->with([
                        'cliente' => $this->data['cliente'],
                        'year'    => $this->data['year'],
                        'trimestres' => $this->data['trimestres'],
                        'archivo' => $this->archivo,
                    ])
                    ->subject($this->subject)
                    ->attach($this->path, [
                        'as' => basename($this->path), // Nombre del archivo
                        'mime' => 'application/pdf', // Tipo MIME
                    ]);
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
}

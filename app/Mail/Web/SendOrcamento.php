<?php

namespace App\Mail\Web;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Markdown;

class SendOrcamento extends Mailable
{
    use Queueable, SerializesModels;

    private $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from($this->data['siteemail'], $this->data['sitename'])
            ->to($this->data['siteemail'], $this->data['sitename'])
            ->replyTo($this->data['reply_email'], $this->data['reply_name'])
            ->subject('⚓️ Anúncio: ' . $this->data['reply_name'])
            ->markdown('emails.orcamento', [
                'name' => $this->data['reply_name'],
                'email' => $this->data['reply_email'],
                'whatsapp' => $this->data['whatsapp'],
                'message' => $this->data['message'],
        ]);
    }
}

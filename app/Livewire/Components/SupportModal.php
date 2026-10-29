<?php

namespace App\Livewire\Components;

use App\Mail\SupportRequestMail;
use App\Services\TelegramService;
use App\Traits\WithToastr;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\On;
use Livewire\Component;

class SupportModal extends Component
{
    use WithToastr;

    public bool $showSupport = false;
    public string $message = '';

    #[On('open-support-modal')]
    public function open()
    {
        $this->showSupport = true;
    }

    public function sendSupport()
    {
        $this->validate([
            'message' => 'required|min:10',
        ]);

        Mail::to(config('app.desenvolvedor_email'))
            ->send(new SupportRequestMail($this->message));

        app(TelegramService::class)->notify('🆘 Nova solicitação de suporte', [
            'Usuário' => auth()->user()?->name,
            'E-mail' => auth()->user()?->email,
            'Mensagem' => $this->message,
        ]);

        $this->reset('message', 'showSupport');

        $this->toastSuccess('Suporte enviado com sucesso');
    }

    public function render()
    {
        return view('livewire.components.support-modal');
    }
}

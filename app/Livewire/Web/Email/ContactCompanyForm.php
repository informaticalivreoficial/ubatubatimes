<?php

namespace App\Livewire\Web\Email;

use App\Mail\Web\ParceiroSend;
use App\Models\Company;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class ContactCompanyForm extends Component
{
    public Company $empresa;

    public $nome;
    public $email;
    public $mensagem;
    public $success = false;

    protected function rules()
    {
        return [
            'nome' => 'required|string|min:3',
            'email' => 'required|email:rfc,dns',
            'mensagem' => 'required|min:10',
        ];
    }

    public function send()
    {
        logger('SEND FOI CHAMADO');
        $data = $this->validate();

        $key = 'contact-'.md5($data['email']);

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $this->addError('email', 'Muitas tentativas. Tente novamente depois.');

            // 🛡️ garante que o estado de loading do Livewire feche corretamente
            // mesmo quando o método retorna cedo por causa do rate limit.
            $this->success = false;

            return;
        }

        RateLimiter::hit($key, 60);

        try {
            $payload = [
                'reply_name' => $data['nome'],
                'reply_email' => $data['email'],
                'mensagem' => $data['mensagem'],

                'empresaemail' => $this->empresa->email,
                'empresaname' => $this->empresa->alias_name,

                'siteemail' => config('mail.from.address'),
                'sitename' => config('app.name'),

                'config_site_name' => config('app.name'),
            ];

            Mail::send(new ParceiroSend($payload));

            $this->reset(['nome', 'email', 'mensagem']);

            $this->success = true;

        } catch (\Exception $e) {
            // 🛡️ se o envio de e-mail falhar, mostra erro em vez de travar
            // o componente em um estado intermediário sem resposta ao frontend.
            logger()->error('Erro ao enviar formulário de contato com empresa', [
                'empresa_id' => $this->empresa->id,
                'error' => $e->getMessage(),
            ]);

            $this->addError('mensagem', 'Não foi possível enviar sua mensagem. Tente novamente em instantes.');
            $this->success = false;
        }
    }

    public function render()
    {
        return view('livewire.web.email.contact-company-form');
    }
}
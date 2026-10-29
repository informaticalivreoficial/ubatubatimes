<?php

namespace Tests\Feature\Web;

use App\Livewire\Web\ContactForm;
use App\Mail\Web\OrcamentoRetorno;
use App\Mail\Web\SendOrcamento;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    public function test_notificacao_interna_vai_para_a_caixa_de_contato_do_site(): void
    {
        Mail::fake();

        config([
            'mail.from.address' => 'suporte@informaticalivre.com.br',
            'mail.contact_to' => 'atendimento@ubatubatimes.com.br',
        ]);

        Livewire::test(ContactForm::class)
            ->set('name', 'Maria Silva')
            ->set('email', 'maria@exemplo.com')
            ->set('message', 'Quero anunciar no portal, por favor.')
            ->call('submit')
            ->assertSet('enviado', true);

        Mail::assertSent(SendOrcamento::class, function (SendOrcamento $mail) {
            // Os destinatários/remetentes são definidos em build(); o fake não
            // executa o build automaticamente.
            return $mail->build()->hasTo('atendimento@ubatubatimes.com.br')
                && $mail->hasFrom('suporte@informaticalivre.com.br')
                && $mail->hasReplyTo('maria@exemplo.com');
        });

        Mail::assertSent(OrcamentoRetorno::class, function (OrcamentoRetorno $mail) {
            return $mail->build()->hasTo('maria@exemplo.com');
        });
    }

    public function test_envio_tambem_notifica_o_telegram(): void
    {
        Mail::fake();
        Http::fake(['api.telegram.org/*' => Http::response(['ok' => true], 200)]);

        config([
            'telegram.enabled' => true,
            'telegram.bot_token' => '123456:token-de-teste',
            'telegram.chat_id' => '-1001234567890',
        ]);

        Livewire::test(ContactForm::class)
            ->set('name', 'Maria Silva')
            ->set('email', 'maria@exemplo.com')
            ->set('whatsapp', '(12) 99999-9999')
            ->set('message', 'Quero anunciar no portal, por favor.')
            ->call('submit')
            ->assertSet('enviado', true);

        Http::assertSent(function ($request) {
            return str_contains($request->url(), '/bot123456:token-de-teste/sendMessage')
                && $request['chat_id'] === '-1001234567890'
                && str_contains($request['text'], 'Maria Silva')
                && str_contains($request['text'], 'Quero anunciar no portal');
        });
    }

    public function test_honeypot_impede_o_envio(): void
    {
        Mail::fake();

        Livewire::test(ContactForm::class)
            ->set('name', 'Robo Spam')
            ->set('email', 'spam@exemplo.com')
            ->set('message', 'Mensagem de spam com tamanho suficiente.')
            ->set('cidade', 'Ubatuba')
            ->call('submit')
            ->assertSet('enviado', false);

        Mail::assertNothingSent();
    }
}

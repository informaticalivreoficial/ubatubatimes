<?php

namespace Tests\Feature\Services;

use App\Services\TelegramService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class TelegramServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'telegram.enabled' => true,
            'telegram.bot_token' => '123456:token-de-teste',
            'telegram.chat_id' => '-1001234567890',
            'telegram.api_url' => 'https://api.telegram.org',
            'telegram.timeout' => 2,
        ]);
    }

    public function test_nao_envia_quando_a_integracao_esta_desabilitada(): void
    {
        Http::fake();

        config(['telegram.enabled' => false]);

        $service = app(TelegramService::class);

        $this->assertFalse($service->isEnabled());
        $this->assertFalse($service->notify('Teste'));
        Http::assertNothingSent();
    }

    public function test_nao_envia_quando_falta_token_ou_chat_id(): void
    {
        Http::fake();

        config(['telegram.chat_id' => null]);

        $this->assertFalse(app(TelegramService::class)->notify('Teste'));
        Http::assertNothingSent();
    }

    public function test_envia_mensagem_formatada_para_o_chat_configurado(): void
    {
        Http::fake([
            'api.telegram.org/*' => Http::response(['ok' => true], 200),
        ]);

        $sent = app(TelegramService::class)->notify('Novo anúncio', [
            'Nome' => 'Maria <script>',
            'E-mail' => 'maria@exemplo.com',
            'Vazio' => null,
        ]);

        $this->assertTrue($sent);

        Http::assertSent(function ($request) {
            return $request->url() === 'https://api.telegram.org/bot123456:token-de-teste/sendMessage'
                && $request['chat_id'] === '-1001234567890'
                && $request['parse_mode'] === 'HTML'
                && str_contains($request['text'], '<b>Novo anúncio</b>')
                && str_contains($request['text'], 'Maria &lt;script&gt;')
                && ! str_contains($request['text'], 'Vazio');
        });
    }

    public function test_erro_da_api_nao_lanca_excecao_e_e_registrado(): void
    {
        Http::fake([
            'api.telegram.org/*' => Http::response(['ok' => false, 'description' => 'chat not found'], 400),
        ]);

        Log::spy();

        $this->assertFalse(app(TelegramService::class)->notify('Teste'));

        Log::shouldHaveReceived('warning')->once();
    }

    public function test_falha_de_conexao_nao_lanca_excecao(): void
    {
        Http::fake([
            'api.telegram.org/*' => fn () => throw new \Illuminate\Http\Client\ConnectionException('timeout'),
        ]);

        $this->assertFalse(app(TelegramService::class)->notify('Teste'));
    }
}

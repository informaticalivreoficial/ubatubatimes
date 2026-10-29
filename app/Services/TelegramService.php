<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Envio de notificações internas via Telegram (Bot API).
 *
 * Nenhuma falha aqui deve interromper o fluxo do formulário: erros são
 * registrados no log e o método retorna false.
 */
class TelegramService
{
    private const MAX_MESSAGE_LENGTH = 4096;

    /**
     * Indica se a integração está habilitada e configurada.
     */
    public function isEnabled(): bool
    {
        return (bool) config('telegram.enabled')
            && filled(config('telegram.bot_token'))
            && filled(config('telegram.chat_id'));
    }

    /**
     * Envia uma notificação formatada com título e pares rótulo/valor.
     *
     * @param  array<string, string|int|float|null>  $fields
     */
    public function notify(string $title, array $fields = []): bool
    {
        $lines = ['<b>' . e($title) . '</b>'];

        foreach ($fields as $label => $value) {
            if (blank($value)) {
                continue;
            }

            $lines[] = '<b>' . e($label) . ':</b> ' . e((string) $value);
        }

        return $this->sendMessage(implode("\n", $lines));
    }

    /**
     * Envia um texto livre (parse_mode HTML) para o chat configurado.
     */
    public function sendMessage(string $text): bool
    {
        if (! $this->isEnabled()) {
            return false;
        }

        try {
            $response = Http::asJson()
                ->acceptJson()
                ->timeout((int) config('telegram.timeout', 5))
                ->post($this->endpoint(), [
                    'chat_id' => (string) config('telegram.chat_id'),
                    'text' => mb_substr($text, 0, self::MAX_MESSAGE_LENGTH),
                    'parse_mode' => 'HTML',
                    'disable_web_page_preview' => true,
                ]);

            if ($response->failed()) {
                Log::warning('Falha ao notificar o Telegram', [
                    'status' => $response->status(),
                    'description' => $response->json('description'),
                ]);

                return false;
            }

            return true;
        } catch (\Throwable $e) {
            Log::warning('Erro ao notificar o Telegram', [
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    private function endpoint(): string
    {
        return rtrim((string) config('telegram.api_url'), '/')
            . '/bot' . config('telegram.bot_token')
            . '/sendMessage';
    }
}

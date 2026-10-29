<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Notificações via Telegram
    |--------------------------------------------------------------------------
    |
    | Usado para avisar a equipe sobre novos envios dos formulários do site
    | (anúncios, contato com empresa e suporte). Crie o bot com o @BotFather,
    | envie uma mensagem para ele e descubra o chat_id em
    | https://api.telegram.org/bot<TOKEN>/getUpdates.
    |
    | Enquanto "enabled" for falso (ou token/chat_id estiverem vazios), as
    | notificações são simplesmente ignoradas, sem quebrar nenhum fluxo.
    |
    */

    'enabled' => (bool) env('TELEGRAM_ENABLED', false),

    'bot_token' => env('TELEGRAM_BOT_TOKEN'),

    'chat_id' => env('TELEGRAM_CHAT_ID'),

    'api_url' => env('TELEGRAM_API_URL', 'https://api.telegram.org'),

    'timeout' => (int) env('TELEGRAM_TIMEOUT', 5),

];

<?php

/*
 * As credenciais do service account podem ser informadas via .env em base64
 * (recomendado para produção/Coolify) ou, na ausência delas, lidas do arquivo
 * local em storage/app/analytics/service-account-credentials.json.
 */
$serviceAccountCredentials = null;

if ($credentials = env('ANALYTICS_CREDENTIALS_BASE64')) {
    // Aceita o valor com quebras de linha, aspas ou prefixo "base64:"
    $credentials = trim($credentials, " \t\n\r\0\x0B\"'");
    $credentials = preg_replace('/^base64:/i', '', $credentials);

    // Aceita também o JSON puro (uma linha), além do base64
    if (str_starts_with($credentials, '{')) {
        $serviceAccountCredentials = json_decode($credentials, true);
    } else {
        $decodedCredentials = base64_decode(preg_replace('/\s+/', '', $credentials), true);

        if ($decodedCredentials !== false) {
            $serviceAccountCredentials = json_decode($decodedCredentials, true);
        }
    }
}

return [

    /*
     * The view id of which you want to display data.
     */
    //'view_id' => env('ANALYTICS_VIEW_ID'),
    'property_id' => env('ANALYTICS_PROPERTY_ID'),

    /*
     * Measurement ID (G-XXXXXXX) usado pela tag gtag.js no site.
     */
    'measurement_id' => env('ANALYTICS_MEASUREMENT_ID'),

    /*
     * Path to the client secret json file. Take a look at the README of this package
     * to learn how to get this file. You can also pass the credentials as an array
     * instead of a file path.
     */
    'service_account_credentials_json' => $serviceAccountCredentials
        ?: storage_path('app/analytics/service-account-credentials.json'),

    /*
     * The amount of minutes the Google API responses will be cached.
     * If you set this to zero, the responses won't be cached at all.
     */
    'cache_lifetime_in_minutes' => 60 * 24,

    /*
     * Here you may configure the "store" that the underlying Google_Client will
     * use to store it's data.  You may also add extra parameters that will
     * be passed on setCacheConfig (see docs for google-api-php-client).
     *
     * Optional parameters: "lifetime", "prefix"
     */
    'cache' => [
        'store' => 'file',
    ],
];

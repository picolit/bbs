<?php

return [

    /*
    |--------------------------------------------------------------------------
    | サードパーティーサービス
    |--------------------------------------------------------------------------
    |
    | このファイルは、Stripe、Mailgun、Mandrillなどのサードパーティーサービスの
    | 証情報を保存しておくためのものです。
    | 様々な認証情報をパッケージから簡単に見つけられるように、この主のタイプの
    | 情報をまとめておくデフォルトの場所を用意するのは、筋が通っているでしょう。
    |
    */

    'mailgun' => [
        'domain' => '',
        'secret' => '',
    ],

    'mandrill' => [
        'secret' => '',
    ],

    'ses' => [
        'key'    => '',
        'secret' => '',
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => App\User::class,
        'key'    => '',
        'secret' => '',
    ],

    'github'   => [
        'client_id'     => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect'      => env('GITHUB_REDIRECT'),
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_APP_ID'),
        'client_secret' => env('FACEBOOK_APP_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT'),
    ],

    'google' => [
        'client_id'     => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect'      => env('GOOGLE_REDIRECT'),
    ],
];

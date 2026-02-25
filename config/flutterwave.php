<?php

declare(strict_types=1);

use Flutterwave\Payments\Services\Modal;
use Flutterwave\Payments\Services\Transactions;
use Flutterwave\Payments\Services\Webhooks;

return [
    'publicKey' => env('FLUTTERWAVE_PUBLIC_KEY'),
    'secretKey' => env('FLUTTERWAVE_SECRET_KEY'),

    'services' => [
        'transactions' => Transactions::class,
        'webhooks' => Webhooks::class,
        'modals' => Modal::class,
    ],

    'paths' => [
        'logs' => storage_path('flutterwave/log'),
    ],

    'secretHash' => env('FLUTTERWAVE_WEBHOOK_SECRET', ''),

    'encryptionKey' => env('FLUTTERWAVE_ENCRYPTION_KEY', ''),

    'env' => env('FLUTTERWAVE_ENV', 'staging'),

    'businessName' => 'Fondation BREE',
    'transactionPrefix' => 'BREE-',
    'logo' => env('APP_URL').'/images/logo.png',
    'title' => 'Fondation BREE',
    'description' => 'Don à la Fondation BREE — Protéger. Élever. Inspirer.',
    'country' => 'CM',
    'currency' => 'EUR',

    'paymentType' => [
        'card',
        'mobilemoneycameroon',
        'mobilemoneyrwanda',
        'mobilemoneyzambia',
        'mobilemoneyghana',
        'banktransfer',
    ],

    'redirectUrl' => env('APP_URL').'/don/merci',

    'successUrl' => env('APP_URL').'/don/merci',

    'cancelUrl' => env('APP_URL').'/faire-un-don',
];

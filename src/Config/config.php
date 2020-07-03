<?php

return [
    
    /*
    |--------------------------------------------------------------------------
    | API Key settings
    |--------------------------------------------------------------------------
    |
    | Set your public & private key
    | please following url for set your public & private key below
    | https://www.coinpayments.net/index.php?cmd=acct_api_keys
    |
    */

    'public_key'    => env('WINCASHPAY_PUBLIC_KEY', ''),
    'private_key'   => env('WINCASHPAY_PRIVATE_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Middleware for make payment
    |--------------------------------------------------------------------------
    |
    | Set the custom middleware 
    | you can set the "auth" or "auth:guard"
    |
    */
    
    'middleware' => ['auth'],

    /*
    |--------------------------------------------------------------------------
    | IPN setting
    |--------------------------------------------------------------------------
    |
    | If you use IPN for get callback response transactions
    | please activate IPN configuration below
    |
    */

    'ipn' => [
        'activate' => env('WINCASHPAY_IPN_ACTIVATE', false),
        'config' => [
            'wincashpay_merchant_id'       => env('WINCASHPAY_MERCHANT_ID', ''),
            'wincashpay_ipn_secret'        => env('WINCASHPAY_IPN_SECRET', ''),
            'wincashpay_ipn_debug_email'   => env('WINCASHPAY_IPN_DEBUG_EMAIL', ''),
        ]
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Currencies setting
    |--------------------------------------------------------------------------
    |
    | please use one currencies for convert coin amount
    | USD, CAD, EUR, ARS, AUD, AZN, BGN, BRL, BYN, CHF, CLP, CNY, COP, CZK
    | DKK, GBP, GIP, HKD, HUF, IDR, ILS, INR, IRR, IRT, ISK, JPY, KRW, LAK, MKD, MXN, ZAR,
    | MYR, NGN, NOK, NZD, PEN, PHP, PKR, PLN, RON, RUB, SEK, SGD, THB, TRY, TWD, UAH, VND,
    |
    */

    'default_currency' => env('WINCASHPAY_CURRENCY', 'USD'),

    /*
    |--------------------------------------------------------------------------
    | Header setting
    |--------------------------------------------------------------------------
    */

    'header' => [
        'default' => 'logo',
        'type' => [
            'logo' => '/wincashpay.logo.png', // path assets file only
            'text' => 'Your payment summary'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Font setting
    |--------------------------------------------------------------------------
    */

    'font' => [
        'family' => "'Roboto', sans-serif"
    ],
];

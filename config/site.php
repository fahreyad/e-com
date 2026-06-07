<?php

return [
    'minimum_withdraw' => 100,
    'minimum_cash_in' => 100,
    'maximum_cash_in' => 1000000,
    'refer_transfer_share_commission_percentage' => 10,
    'withdraw_charge' => 10,
    'package_refer_commission_on_pv' => 20,
    'generation_commission_percentage' => [
        .5, .5, .5, .5, .5, .5, .5, .5, .5, .5,
    ],
    'matching_slot' => 1500,
    'matching_commission_percentage' => 10,
    'cashback_days' => 365,
    'withdraw_agent_commission_percentage' => 4,

    'sms' => [
        'apiUrl' => env('SMS_API_URL', 'http://smpp.ajuratech.com:7788/sendtext'),
        'apiKey' => env('SMS_API_KEY', ''),
        'secretKey' => env('SMS_SECRET_KEY', ''),
        'callerID' => env('SMS_CALLER_ID', env('APP_NAME')),
    ],
];

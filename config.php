<?php

return [
    'database' => [
        'host' => 'localhost',
        'username' => 'mahsenir_sharj',
        'password' => 'a!#Z2J9s-BQMWVgE',
        'dbname' => 'mahsenir_sharj',
        'charset' => 'utf8mb4'
    ],
    'app' => [
        'name' => 'BuildingChargeManager',
        'base_url' => 'https://mahsen81.ir/sharj',
        'debug' => false,
        'default_timezone' => 'Asia/Tehran',
    ],
    'security' => [
        'csrf_secret' => 'c1a8f7b7e2d4c9a3b6d5e8f1a2b3c4d5', // A random secret key
        'session_name' => 'BCM_SESS',
    ],
    'notifications' => [
        'telegram' => [ 'bot_token' => '', 'chat_id' => '' ],
        'sms' => [ 'api_key' => '', 'sender' => '' ],
        'whatsapp' => [ 'api_key' => '' ],
    ]
];

<?php

// Exit if accessed directly.
// This is not strictly necessary for the config file but is good practice.
if (count(get_included_files()) === 1) {
    exit('Direct access is not allowed.');
}

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
        'base_url' => 'https://mahsen81.ir/sharj', // Corrected base URL
        'debug' => false, // Set to false for production
        'default_timezone' => 'Asia/Tehran',
    ],
    'security' => [
        'csrf_secret' => 'dfgfdgfdgfdgfdgfdgfdgfdg', // Please generate a long random string here
        'session_name' => 'BCM_SESS',
    ],
    'notifications' => [
        'telegram' => [
            'bot_token' => 'YOUR_TELEGRAM_BOT_TOKEN',
            'chat_id' => 'YOUR_TELEGRAM_CHAT_ID',
        ],
        'sms' => [
            'api_key' => 'YOUR_SMS_API_KEY',
            'sender' => 'YOUR_SMS_SENDER_NUMBER',
        ],
        'whatsapp' => [
            'api_key' => 'YOUR_WHATSAPP_BUSINESS_API_KEY',
        ],
    ]
];

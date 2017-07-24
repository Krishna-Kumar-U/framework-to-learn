<?php

return [
	'root' => '/',
    'database' => [
        'name' => env('DB_NAME', 'DB'),
        'username' => env('DB_USER', 'root'),
        'password' => env('DB_PASSWORD', ''),
        'connection' => 'mysql:host='.env('DB_HOST', '127.0.0.1'),
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_STATEMENT_CLASS => ['DebugQuery', []],
        ]
    ]
];
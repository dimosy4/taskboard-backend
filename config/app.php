<?php
return [
    'app' => ['name' => 'TaskBoard', 'env' => getenv('APP_ENV') ?: 'dev'],
    'db' => [
        'driver' => 'pgsql', 'host' => getenv('DB_HOST') ?: '127.0.0.1',
        'port' => getenv('DB_PORT') ?: '5432',
        'database' => getenv('DB_DATABASE') ?: 'taskboard',
        'username' => getenv('DB_USERNAME') ?: 'postgres',
        'password' => getenv('DB_PASSWORD') ?: '',
        'charset' => 'utf8', 'prefix' => '', 'schema' => 'public',
    ],
    'secret' => 'enc:aIoHiAfPu3YwfL79bzBVP8SMNINTIinrgXlx0MB4MCM91WUpGnWMSWrybA=='
];
    
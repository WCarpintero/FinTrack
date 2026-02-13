<?php

$path = __DIR__ . "/../../.env";
$env = parse_ini_file($path);

return [
    'host' => $env['DB_HOST'],
    'db' => $env['DB_NAME'],
    'user' => $env['DB_USER'],
    'pass' => $env['DB_PASSWORD'],
    'charset' => $env['DB_CHARSET']
];
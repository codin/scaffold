<?php 

return [
    'driver'    => env('DB_DRIVER', 'mysql'),
    'host'      => env('DB_HOST', 'mysql'),
    'database'  => env('DB_NAME', 'database'),
    'username'  => env('DB_USER', 'username'),
    'password'  => env('DB_PASS', 'password'),
    'charset'   => env('DB_CHARSET', 'utf8'),
    'collation' => env('DB_COLLATION', 'utf8_unicode_ci'),
    'prefix'    => env('DB_PREFIX', ''),
];
<?php 
    
/**
 * In this file, define your database configuration
 * details. Ideally this should all come from env
 * variables.
 */

return [

    /**
     * The default database configuration which
     * is used on load of this application.
     */
    'default' => [
        'driver'    => env('DB_DRIVER', 'mysql'),
        'host'      => env('DB_HOST', 'mysql'),
        'database'  => env('DB_NAME', 'database'),
        'username'  => env('DB_USER', 'username'),
        'password'  => env('DB_PASS', 'password'),
        'charset'   => env('DB_CHARSET', 'utf8'),
        'collation' => env('DB_COLLATION', 'utf8_unicode_ci'),
        'prefix'    => env('DB_PREFIX', ''),
    ],

    /**
     * The path where the migrations files are
     * kept, from the root.
     */
    'migrations_path' => env('MIGRATIONS_PATH', '/migrations'),

    /**
     * Define the path to the migration template file,
     * from the root of the app.
     */
    'migration_template' => '/storage/migration_template.txt',
    
];
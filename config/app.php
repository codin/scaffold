<?php 

/**
 * Application configuration here, this is where you can
 * add your custom application configuration.
 */

return [
        
    /**
     * The URL for this application, used
     * in URL generation.
     */
    'url' => env('APP_URL', 'locahost'),

    /**
     * Is this a secure HTTPS-only application
     */
    'secure' => (bool)env('SECURE', 0),

    /**
     * The timezone for this application
     */
    'timezone' => env('TIMEZONE', 'Europe/London'),

    /**
     * The date format for this application
     */
    'date_format' => env('DATE_FORMAT', 'd/m/Y'),

    /**
     * Configuration for the time format
     * which you wish to use in this application
     */
    'time_format' => env('TIME_FORMAT', 'h:i:s'),

    /**
     * Cryptographically secure token should
     * be used here.
     */
    'app_token' => env('APP_TOKEN', '6e40dbb0b5ea620d42c5cf10cc4e0285'),

    /**
     * The path to the log file from the root
     * of the application.
     */
    'log_file'  => env('LOG_FILE', '/logs/scaffold.log'),
];
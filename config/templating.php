<?php 

/**
 * Your applications templating configuration
 */

return [
        
    /**
     * The path to the public folder from the root
     * of the application
     */
    'public_path' => env('PUBLIC_PATH', '/public'),

    /**
     * The path to the assets folder from the root
     * of the public folder
     */
    'asset_path' => env('ASSET_PATH', '/assets'),

    /**
     * The path to the views from the root
     * of the application.
     */
    'view_path' => env('VIEW_PATH', '/views/%name%'),

    /**
     * The path to the modules from view_path. This should be the folder
     * with which modules are stored in.
     */
    'module_path' => env('MODULE_PATH', 'modules'),

    /**
     * Name => Class mapping for our modules.
     */
    'modules' => [
        'header' => \App\Modules\Header::class,
    ],

];
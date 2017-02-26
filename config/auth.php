<?php 

/**
 * Auth configuration here.
 */

return [

    // The key we store the auth session
    // under in your chosen session provider.
    'session_key' => env('SESSION_KEY', 'auth'),
    
    // Set our auth redirects for when we login
    // and for when we logout of our application.
    'login_redirect'  => env('LOGIN_REDIRECT', '/'),
    'logout_redirect' => env('LOGOUT_REDIRECT', '/'),

    // The classname for the model which implements the
    // Authable interface and uses the Authable trait.
    'authable_model'  => 'App\Models\User',
];
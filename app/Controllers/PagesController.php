<?php 

namespace App\Controllers;

use App\Controllers\Controller;

/**
 * Handle the static pages of our application, this 
 * is a great example of how to make use
 * of the controllers.
 */
class PagesController extends Controller
{   
    /**
     * Show the home view
     * 
     * @return Scaffold\Http\Response
     */
    public function home()
    {
        dispatch(new \App\Events\MyEvent('Welcome to'));

        return response()->view('index.php', [
            'text' => 'Scaffold',
        ]);
    }
}
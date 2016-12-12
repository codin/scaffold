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
        // Dispatch example event to add "Welcome to" to the
        // title in the view.
        // dispatch(new \App\Events\MyEvent('Welcome to'));

        // Return our view with the text "Scaffold" to be
        // displayed in the title.
        return response()->view('index.php', [
            'text'    => 'Scaffold',
            'message' => 'Welcome to',
        ]);
    }
}
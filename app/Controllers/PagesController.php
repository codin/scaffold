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
        // Example writing some json data to a file.
        // storage()->write('test.json', json_encode(['foo' => 'bar']));

        // Dispatch example event to add "Welcome to" to the
        // title in the view.
        // dispatch(new \App\Events\MyEvent('Welcome to'));

        // Return our view with the text "Scaffold" to be
        // displayed in the title.
        return response()
            ->script('/js/app.js')
            ->style('/css/main.css')
            ->view('index.php', [
                'text'    => 'Scaffold',
                'message' => 'Welcome to',
            ]);
    }
}
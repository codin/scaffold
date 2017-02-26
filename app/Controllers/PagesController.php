<?php 

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\User;
use Scaffold\Mail\Message;

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
        // Return our view with the text "Scaffold" to be
        // displayed in the title.
        return response()
            ->style('/css/welcome.css')
            ->view('index.php', [
                'text'    => 'Scaffold',
                'message' => 'Welcome to',
            ]);
    }
}
<?php 

namespace App\Controllers;

use App\Controllers\Controller;
use Scaffold\Http\Request;
use Scaffold\Http\Response;

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
     * @return Response
     */
    public function home(Request $request, Response $response)
    {
        return $response->view('index.php', ['text' => 'Welcome to Scaffold']);
    }
}
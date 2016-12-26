<?php 

namespace App\Controllers;

use App\Controllers\Controller;

/**
 * Example resource controller
 */
class ArticlesController extends Controller
{   
    /**
     * Example resource read endpoint
     * 
     * @param  array $params
     * @return void
     */
    public function read($params)
    {
        dd($params);
    }
}
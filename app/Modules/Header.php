<?php 

namespace App\Modules;

use App\Modules\Module;

/**
 * Our header module
 */
class Header extends Module
{   
    /**
     * The template file which we need
     * to render for this module.
     * 
     * @var string
     */
    protected $template = 'header.php';

    /**
     * Is this module cacheable?
     * 
     * @var boolean
     */
    protected $cacheable = true;
}
<?php 

namespace Scaffold\Http;

use Scaffold\Html\Template;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Extend the existing response class so that we can
 * handle rending specific content types, processing
 * our templates etc.
 */
class Response extends SymfonyResponse
{

    /**
     * Render a view by name, and pass some arguments to it
     * 
     * @param  string $name
     * @param  array  $arguments
     * @return Scaffold\Html\Template
     */
    public function view($name, array $arguments)
    {
        $template = new Template($name, $arguments);

        return $this->setContent($template->render());
    }
}
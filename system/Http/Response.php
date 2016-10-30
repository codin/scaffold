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
     * @return Scaffold\Http\Response
     */
    public function view($name, array $arguments)
    {
        $template = new Template($name, $arguments);

        return $this->setContent($template->render());
    }

    /**
     * Render a json response
     * 
     * @param  mixed $data
     * @return Scaffold\Http\Response
     */
    public function json($data)
    {
        $json = json_encode($data, JSON_PRETTY_PRINT);
        $this->headers->set('Content-Type', 'application/json');

        return $this->setContent($json);
    }
}
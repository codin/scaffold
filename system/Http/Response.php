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
     * The arguments which can be passed to the
     * response, namely when rendering a view.
     * 
     * @var array
     */
    public $arguments = [];

    /**
     * Add a new argument to this response
     * 
     * @param string $key
     * @param mixed $data
     * @return Scaffold\Http\Response
     */
    public function addArgument($key, $data)
    {
        $this->arguments[$key] = $data;
        return $this;
    }

    /**
     * Add a new script to the arguments, so that we can 
     * render it out on the view
     * 
     * @param  string  $path           
     * @param  boolean $use_public_path
     * @return Scaffold\Http\Response     
     */
    public function script($path, $use_public_path = true)
    {
        if (!isset($this->arguments['scripts']) || !is_array($this->arguments['scripts'])) {
            $this->arguments['scripts'] = [];
        }

        $this->arguments['scripts'][] = ($use_public_path ? asset_path() : '') . $path;

        return $this;
    }

    /**
     * Add a new style to the arguments, so that we can 
     * render it out on the view
     * 
     * @param  string  $path           
     * @param  boolean $use_public_path
     * @return Scaffold\Http\Response     
     */
    public function style($path, $use_public_path = true)
    {
        if (!isset($this->arguments['styles']) || !is_array($this->arguments['styles'])) {
            $this->arguments['styles'] = [];
        }

        $this->arguments['styles'][] = ($use_public_path ? asset_path() : '') . $path;

        return $this;
    }

    /**
     * Render a view by name, and pass some arguments to it
     * 
     * @param  string $name
     * @param  array  $arguments
     * @return Scaffold\Http\Response
     */
    public function view($name, array $arguments)
    {
        $this->arguments = array_merge($this->arguments, $arguments);
        $template = new Template($name, $this->arguments);

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
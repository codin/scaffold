<?php 

namespace Scaffold\Http;

use Psr\Http\Message\ResponseInterface;
use Scaffold\Html\Template;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
    public function view($name, $arguments = [])
    {
        if (!is_array($arguments)) {
            throw new \Exception('Arguments passed to view in response must be an array.');
        }

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

    /**
     * Create a redirect response, to a
     * provided url.
     * 
     * @param  string $url
     * @return Scaffold\Http\Response
     */
    public function redirect($url)
    {
        return new RedirectResponse($url);
    }

    /**
     * Convert the response to a Psr
     * supporting interface.
     * 
     * @return Psr\Http\Message\ResponseInterface
     */
    public function asPsr() : ResponseInterface
    {
        return static::toPsr($this);
    }

    /**
     * Convert a symfony response to Psr
     * 
     * @param  SymfonyResponse $response
     * @return Psr\Http\Message\ResponseInterface
     */
    public static function toPsr(SymfonyResponse $response) : ResponseInterface
    {
        $psrFactory = new DiactorosFactory();
        return $psrFactory->createResponse($response);
    }

    /**
     * Create a new HTTP Response from Psr
     *
     * @param  Psr\Http\Message\ResponseInterface $response
     * @return Scaffold\Http\Response
     */
    public static function fromPsr(ResponseInterface $response)
    {
        $httpFoundationFactory = new HttpFoundationFactory();
        return $httpFoundationFactory->createResponse($response);
    }
}
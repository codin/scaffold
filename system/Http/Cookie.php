<?php 

namespace Scaffold\Http;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * This class handles cookies in the responses
 * to the applications client.
 */
class Cookie
{       
    /**
     * The response in the application.
     * 
     * @var Symfony\Component\HttpFoundation\Response
     */
    protected $response;

    /**
     * Set the response for this cookie handler.
     * 
     * @param Symfony\Component\HttpFoundation\Response $response
     */
    public function setResponse(SymfonyResponse $response) 
    {
        $this->response = $response;

        return $this;
    }

    /**
     * We want to alias methods on the response
     * headers object for manipulating the 
     * cookies in the response.
     * 
     * @param  string $method
     * @param  array  $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        if (!$this->response) {
            return false;
        }

        $expected_method = $method . 'Cookie' . ($method == 'get' ? 's' : '');
        
        if (method_exists($this->response->headers, $expected_method)) {
            return call_user_method_array($expected_method, $this->response->headers, $arguments);
        }

        return false;
    }
}
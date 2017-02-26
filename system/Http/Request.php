<?php 

namespace Scaffold\Http;

use Psr\Http\Message\RequestInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

/**
 * Extend symfonys request class so we can do stuff like
 * propogate middleware and what not.
 */
class Request extends SymfonyRequest
{

    /**
     * Construct our parent with all of the REQUEST
     * Super globals.
     */
    public function __construct()
    {
        parent::__construct(
            $_GET,
            $_POST,
            [],
            $_COOKIE,
            $_FILES,
            $_SERVER
        );
    }

    /**
     * Convert this request to a Psr one.
     * 
     * @return Psr\Http\Message\ResponseInterface
     */
    public function asPsr() : RequestInterface
    {
        return static::toPsr($this);
    }

    /**
     * Convert a symfony request to Psr
     * 
     * @param  Symfony\Component\HttpFoundation\Request $request
     * @return Psr\Http\Message\RequestInterface
     */
    public static function toPsr(SymfonyRequest $request) : RequestInterface
    {
        $psrFactory = new DiactorosFactory();
        return $psrFactory->createRequest($request);
    }
}
<?php 

namespace Scaffold\Http;

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
}
<?php 

namespace Scaffold\Exception;

class NoAuthableLoggedInException extends \Exception
{
    public function __construct()
    {
        parent::__construct('No active login or session malformed, cannot retrieve Authable.');
    }
}
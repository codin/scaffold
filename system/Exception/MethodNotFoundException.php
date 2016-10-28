<?php 

namespace Scaffold\Exception;

class MethodNotFoundException extends \Exception
{
    public function __construct($controller, $method_name)
    {
        parent::__construct(get_class($controller) . '::' . $method_name);
    }
}
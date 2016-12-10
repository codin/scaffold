<?php

namespace App\Events;

use Scaffold\Eventing\Event;

/**
 * Your application event.
 */
class MyEvent extends Event
{   
    /**
     * Example message property
     * 
     * @var string
     */
    public $message;

    /**
     * Example construction of an event
     * that takes in some data.
     * 
     * @param string $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }
}
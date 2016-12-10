<?php 

namespace App\Listeners;

use Scaffold\Eventing\Event;
use Scaffold\Eventing\EventListener;

/**
 * Your application "MyEvent" listener
 */
class MyEventListener extends EventListener
{   
    /**
     * What events to look for and what method to
     * fire when they happen.
     * 
     * @var array
     */
    protected $events = [
        'my.event' => 'onMyEvent',
    ];

    /**
     * Handle the my.event event being fired.
     * 
     * @param  Event  $event
     * @return void
     */
    public function onMyEvent(Event $event)
    {
        // Add the message as an argument to the response
        response()->addArgument('message', $event->message);
    }
}
<?php 

namespace Scaffold\Eventing;

use Symfony\Component\EventDispatcher\Event as SymfonyEvent;
    
/**
 * Our Scaffold event class which all application events
 * should inherit.
 */
class Event extends SymfonyEvent
{   
    /**
     * Get the event name for this if we need
     * to. In the case that we don't already
     * know which one to be used to identify
     * this event in the system.
     *
     * App\Events\Test => app.events.test
     * 
     * @return string
     */
    public function getEventName()
    {
        return trim(str_replace('\\', '.', strtolower(self::class)), '\\');
    }
}
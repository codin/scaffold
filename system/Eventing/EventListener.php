<?php 

namespace Scaffold\Eventing;

/**
 * Our scaffold application event listener which we expect
 * all application event listeners to extend.
 */
class EventListener
{
    /**
     * This array should be overriden and populated
     * with the events which this listener will be handling
     * and map to the methods which will be called.
     * 
     * @var array
     */
    protected $events = [];

    /**
     * Get the array of events we're expecting 
     * this listener to handle.
     * 
     * @return array
     */
    public function getEvents()
    {
        return $this->events;
    }
}
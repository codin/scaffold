<?php 

namespace Scaffold\Queue;

use Scaffold\Traits\AdapterPattern;
use Scaffold\Queue\Adapters\QueueAdapter;

/**
 * The queue system for Scaffold.
 */
class Queue
{
    use AdapterPattern;

    /**
     * Construct our queue with the adapter we're going to be using.
     * 
     * @param Scaffold\Queue\Adapters\QueueAdapter $adapter
     */
    public function __construct(QueueAdapter $adapter)
    {
        $this->adapter = $adapter;
    }
}
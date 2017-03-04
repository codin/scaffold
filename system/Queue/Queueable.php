<?php 

namespace Scaffold\Queue;

use Scaffold\Queue\QueueableInterface;

/**
 * Implement the functionality
 * for a queueable entity.
 */
trait Queueable
{
    /**
     * Queue the entity which uses this trait.
     * 
     * @return QueueableInterface
     */
    public function queue() : QueueableInterface
    {
        queue()->push(
            $this->serializeForQueue(), 
            $this->getQueueName()
        );

        return $this;
    }

    /**
     * Serialize this entity for the queue
     * 
     * @return string
     */
    public function serializeForQueue()
    {
        return serialize($this);
    }

    /**
     * Get the default queue name for all
     * Queueable enities in the application.
     * 
     * @return string
     */
    public function getQueueName()
    {
        return config()->get('queue.queue_name');
    }
}
<?php 

namespace Scaffold\Queue\Adapters;

use Scaffold\Queue\Adapters\QueueAdapter;
use Scaffold\Queue\Queue;
use Scaffold\Queue\QueueableInterface;

/**
 * Define the adapter which uses the database to store
 * the queue items.
 */
class DatabaseQueueAdapter implements QueueAdapter
{
    /**
     * Push a new item into the database.
     * 
     * @param  QueueableInterface $item
     * @param  strinb             $queueName
     * @return Queue
     */
    public function push(QueueableInterface $item, $queueName) : Queue
    {
        $queue = queue();

        return $queue;
    }

    /**
     * Pop an item from the queue.
     * 
     * @param  string $queueName
     * @return QueueableInterface
     */
    public function pop($queueName) : QueueableInterface
    {
        
    }
}
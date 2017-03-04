<?php 

namespace Scaffold\Queue\Adapters;

use Scaffold\Queue\Queue;
use Scaffold\Queue\QueueableInterface;

/**
 * The interface for our queue adapters.
 */
interface QueueAdapter
{
    public function push(QueueableInterface $item, $queueName) : Queue;
    public function pop($queueName) : QueueableInterface;
}
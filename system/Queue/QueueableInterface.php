<?php 

namespace Scaffold\Queue;

/**
 * The interface for a Queueable item.
 */
interface QueueableInterface
{
    public function queue() : QueueableInterface;
    public function serializeForQueue();
    public function getQueueName();
}
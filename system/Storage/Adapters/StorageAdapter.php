<?php 

namespace Scaffold\Storage\Adapters;

/**
 * The interface which storage adapters must
 * adhere to in order to be used within the
 * system.
 */
interface StorageAdapter
{
    public function write($key, $value);
    public function read($key);
    public function delete($key);
    public function copy($oldKey, $newKey);
    public function move($oldKey, $newKey);
}
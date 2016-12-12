<?php 

namespace Scaffold\Storage\Caching\Adapters;

/**
 * The interface for our caching adapters.
 */
interface CacheAdapter
{
    public function get($key);
    public function set($key, $value);
    public function flush();
    public function remove($key);
    public function generateKey($key);
}
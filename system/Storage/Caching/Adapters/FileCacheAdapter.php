<?php

namespace Scaffold\Storage\Caching\Adapters;

use Symfony\Component\Filesystem\Filesystem;
use Scaffold\Storage\Caching\Adapters\CacheAdapter;

/**
 * Implementation of caching using a simple filesystem.
 */
class FileCacheAdapter extends Filesystem implements CacheAdapter
{
    /**
     * Get a single cache file by key
     * 
     * @param  string $key
     * @return string|boolean
     */
    public function get($key)
    {
        $key = $this->generateKey($key);
        
        if (!$this->exists($key)) {
            return false;
        }

        return file_get_contents($key);
    }
    
    /**
     * Set a cache item by key to a value
     * 
     * @param  string $key
     * @param  mixed $value
     * @return mixed
     */
    public function set($key, $value)
    {
        $original = $value;

        if (!is_string($value)) {
            $value = serialize($value);
        }

        $key = $this->generateKey($key);
        $this->dumpFile($key, $value);

        return $original;
    }
        
    /**
     * Flush the cache entirely.
     * 
     * @return void
     */
    public function flush()
    {
        $this->remove([cache_path()]);
    }

    /**
     * Remove a specific key from the cache.
     * 
     * @param  string $key
     * @return void
     */
    public function delete($key)
    {
        $key = $this->generateKey($key);
        $this->remove([$key]);
    }

    /**
     * Generate the key we're going to use to
     * store the data for a specific key under.
     * This must produce the same output for the same
     * input everytime.
     * 
     * @param  string $key
     * @return string
     */
    public function generateKey($key)
    {
        return cache_path() . '/' . md5($key);
    }
}
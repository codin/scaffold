<?php 

namespace Scaffold\Storage\Caching;

use Scaffold\Storage\Caching\Adapters\CacheAdapter;

/**
 * The primary cache interface for this
 * application.
 */
class Cache
{
    /**
     * The cache adapter we're using
     * 
     * @var Scaffold\Storage\Caching\Adapters\CacheAdapter
     */
    protected $adapter;

    /**
     * Construct our caching system with the adapter
     * which we're going to be using.
     * 
     * @param Scaffold\Storage\Caching\Adapters\CacheAdapter $adapter
     */
    public function __construct(CacheAdapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Call methods on the adapter
     * 
     * @param  string $method
     * @param  array  $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        return call_user_func_array([$this->adapter, $method], $arguments);
    }
}
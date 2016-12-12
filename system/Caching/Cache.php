<?php 

namespace Scaffold\Caching;

use Scaffold\Caching\Adapters\CacheAdapter;
use Scaffold\Traits\AdapterPattern;

/**
 * The primary cache interface for this
 * application.
 */
class Cache
{
    use AdapterPattern;

    /**
     * The cache adapter we're using
     * 
     * @var Scaffold\Caching\Adapters\CacheAdapter
     */
    protected $adapter;

    /**
     * Construct our caching system with the adapter
     * which we're going to be using.
     * 
     * @param Scaffold\Caching\Adapters\CacheAdapter $adapter
     */
    public function __construct(CacheAdapter $adapter)
    {
        $this->adapter = $adapter;
    }
}
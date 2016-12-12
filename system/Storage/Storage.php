<?php 

namespace Scaffold\Storage;

use Scaffold\Storage\Adapters\StorageAdapter;
use Scaffold\Traits\AdapterPattern;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Handle the storage of files for our application
 * using adapters to define how & where we store
 * files.
 */
class Storage
{   
    use AdapterPattern;

    /**
     * The adapter we're using for this storage
     * interface.
     * 
     * @var Scaffold\Storage\Adapters\StorageAdapter;
     */
    protected $adapter;

    /**
     * Construct the storage system
     * with the default adapter we're
     * going to be using.
     */
    public function __construct(StorageAdapter $adapter)
    {
        $this->adapter = $adapter;
    }
}
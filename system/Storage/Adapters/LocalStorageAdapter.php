<?php 

namespace Scaffold\Storage\Adapters;

use Scaffold\Storage\Adapters\StorageAdapter;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * The storage adapter for the local
 * filesystem.
 */
class LocalStorageAdapter implements StorageAdapter
{
    /**
     * The filesystem we're going to be using
     * to access the files we need.
     *
     * @var Symfony\Component\Filesystem\Filesystem
     */
    protected $fs;   

    /**
     * The system we're going to use to lookup
     * files in the local storage.
     * 
     * @var Symfony\Component\Finder\Finder
     */
    protected $finder;

    /**
     * The base path for files.
     * 
     * @var string
     */
    protected $base_path;

    /**
     * Construct this adapter with a new instance
     * of the filesystem class.
     */
    public function __construct($base_path = '/')
    {
        $this->base_path = $base_path;
        $this->fs = new Filesystem;
        $this->finder = new Finder;
    }

    /**
     * Write a new value to a file by key, key being the
     * path to the file including the name & extension.
     * 
     * @param  string $key
     * @param  string $value
     * @return void
     */
    public function write($key, $value)
    {
        $original = $value;

        if (!is_string($value)) {
            $value = serialize($value);
        }

        $this->fs->dumpFile($this->base_path . $key, $value);

        return $original;
    }

    /**
     * Read a file from the local storage, 
     * by it's key.
     * 
     * @param  string $key
     * @return string
     */
    public function read($key)
    {
        if (!$this->fs->exists($this->base_path . $key)) {
            return false;
        }

        return file_get_contents($this->base_path . $key);
    }

    /**
     * Delete an item from the local storage
     * by key.
     * 
     * @param  string $key
     * @return void
     */
    public function delete($key)
    {
        $this->fs->remove([$this->base_path . $key]);
    }

    /**
     * Copy a file from one key to another
     * 
     * @param  string $oldKey
     * @param  string $newKey
     * @return void
     */
    public function copy($oldKey, $newKey)
    {
        $value = $this->read($this->base_path . $oldKey);
        $this->write($this->base_path . $newKey, $this->base_path . $value);
    }

    /**
     * Move a file from one key to another
     * 
     * @param  string $oldKey
     * @param  string $newKey
     * @return void
     */
    public function move($oldKey, $newKey)
    {
        $this->copy($this->base_path . $oldKey, $this->base_path . $newKey);
        $this->delete($this->base_path . $oldKey);
    }

    /**
     * Give access to the finder so that
     * filesystem searches can be made locally.
     * 
     * @return Symfony\Component\Finder\Finder
     */
    public function find()
    {
        return $this->finder;
    }

    /**
     * Provide access to the filesystem so that
     * custom actions can be made on it if
     * it is necessary for the application.
     * 
     * @return Symfony\Component\Filesystem\Filesystem
     */
    public function filesystem()
    {
        return $this->fs;
    }
}
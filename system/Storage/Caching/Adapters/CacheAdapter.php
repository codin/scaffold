<?php 

namespace Scaffold\Storage\Caching\Adapters;

/**
 * The interface for our caching adapters.
 */
abstract class CacheAdapter
{

    /**
     * The namespace for the cache.
     * 
     * @var string
     */
    protected $namespace = '';

    public abstract function get($key);
    public abstract function set($key, $value);
    public abstract function flush();
    public abstract function delete($key);
    public abstract function generateKey($key);

    /**
     * Set the namespace for the key of the
     * cache adapater.
     * 
     * @param string $namespace
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
        return $this;
    }

    /**
     * Get the namespace.
     * 
     * @return string
     */
    public function getNamespace()
    {
        $namespace = trim(str_replace('.', '/', $this->namespace), '/');

        if (!empty($namespace)) {
            $namespace .= '/';
        }

        return $namespace;
    }
}
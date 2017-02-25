<?php 

namespace Scaffold\Traits;

/**
 * Clases which make use of this trait suggest that they
 * use the adapter pattern and any methods which aren't class
 * specific which are called on them will be called on their adapter.
 */
trait AdapterPattern
{
    /**
     * Handle calling methods in the adapter
     * 
     * @param  string $method
     * @param  array  $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        if (!method_exists($this->getAdapter(), $method)) {
            throw new \Exception('Method "' . $method . '" doesn\'t exist on adapter');
        }
        
        return $this->getAdapter()->$method(...$arguments);    
    }

    /**
     * Get the adapter directly
     * 
     * @return mixed
     */
    public function getAdapter()
    {
        return $this->adapter;
    }
}
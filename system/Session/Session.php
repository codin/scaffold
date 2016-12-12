<?php 

namespace Scaffold\Session;

use Scaffold\Exception\SessionNotStartedException;
use Scaffold\Session\Adapters\SessionAdapter;

/**
 * Handle interactions with the sessions
 * on this application
 */
class Session
{       
    /**
     * The adapter used to store the
     * session data.
     * 
     * @var SessionAdapter
     */
    protected $adapter;

    /**
     * Construct the session object and pass in
     * the adapter which we're going to be using.
     * 
     * @param SessionAdapter $adapter
     */
    public function __construct(SessionAdapter $adapter)
    {
        $status = session_status();

        if ($status != PHP_SESSION_ACTIVE) {
            throw new SessionNotStartedException();
        }

        $this->adapter = $adapter;
    }

    /**
     * Handle calling methods in the adapter
     * 
     * @param  string $method
     * @param  array  $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        if (!method_exists($this->adapter, $method)) {
            throw new Exception('Method doesn\'t exist on adapter');
        }
        
        return $this->adapter->$method(...$arguments);    }
}
<?php 

namespace Scaffold\Session;

use Scaffold\Exception\SessionNotStartedException;
use Scaffold\Session\Adapters\SessionAdapter;
use Scaffold\Traits\AdapterPattern;

/**
 * Handle interactions with the sessions
 * on this application
 */
class Session
{      
    use AdapterPattern;

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
}
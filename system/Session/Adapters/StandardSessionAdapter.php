<?php 

namespace Scaffold\Session\Adapters;

use Scaffold\Exception\SessionNotStartedException;
use Scaffold\Session\Adapters\SessionAdapter;

/**
 * The adapter for standard PHP sessions with the 
 * SESSION global variable.
 */
class StandardSessionAdapter implements SessionAdapter
{   
    /**
     * Delete an item from the session
     * 
     * @param  string $key
     * @return SessionAdapter
     */
    public function delete($key)
    {
        $this->checkIsStarted();
        unset($_SESSION[$key]);

        return $this;
    }

    /**
     * Put an item into the session
     * 
     * @param  string $key
     * @param  mixed  $value
     * @return mixed
     */
    public function put($key, $value)
    {
        $this->checkIsStarted();
        return $_SESSION[$key] = $value;
    }
        
    /**
     * Is a session item set?
     * 
     * @param  string  $key
     * @return boolean
     */
    public function has($key)
    {
        $this->checkIsStarted();
        return isset($_SESSION[$key]);
    }
        
    /**
     * Get an item from the session
     * 
     * @param  string $key
     * @return mixed
     */
    public function get($key)
    {
        $this->checkIsStarted();
        $value = $_SESSION[$key];

        if ($this->has('flash::' . $key)) {
            $this->delete($key);
        }

        return $value;
    }

    /**
     * Put an item into the session as a flash key
     * upon getting this key it will be removed.
     * 
     * @param  string $key
     * @param  mixed  $value
     * @return mixed
     */
    public function flash($key, $value)
    {
        $this->checkIsStarted();

        $this->put($key, $value);
        $this->put('flash::' . $key, true);

        return $value;
    }

    /**
     * Start the session
     * 
     * @return void
     */
    public function start()
    {
        session_start();

        $this->id = session_id();
    }

    /**
     * Get the session id
     * 
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    private function checkIsStarted()
    {
        $status = session_status();

        if ($status != PHP_SESSION_ACTIVE) {
            throw new SessionNotStartedException();
        }
    }
}
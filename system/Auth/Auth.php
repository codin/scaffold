<?php 

namespace Scaffold\Auth;

use Scaffold\Session\Adapters\SessionAdapter;

/**
 * Handle authentication within the application.
 */
class Auth
{   
    /**
     * The session instance we're using
     * to keep track of whether the user
     * is logged in or not.
     * 
     * @var Scaffold\Session\Adapters
     */
    protected $session;

    /**
     * The configuration for the
     * authentication module.
     * 
     * @var array
     */
    protected $config;

    /**
     * Construct our authentication system. Allow
     * the session system to be injected if we wish
     * to use something else for it.
     *
     * @param  Scaffold\Session\Adapters\SessionAdapter|null $session
     */
    public function __construct($session = null)
    {   
        $this->session = session()->getAdapter();

        if (!is_null($session) && $session instanceof SessionAdapter) {
            $this->session = $session;
        }

        $this->config = config()->get('auth');
    }
    
    /**
     * Login a user, force redirecting to the
     * specified login redirect url.
     * 
     * @return void
     */
    public function login()
    {

    }

    /**
     * Logout the current session. Forcing the
     * appication to redirect the user to a 
     * specified logout url.
     * 
     * @return void
     */
    public function logout()
    {

    }

    /**
     * Check to see if we have a session.
     * 
     * @return boolean
     */
    public function loggedIn()
    {
        return $this->session->has($this->config['session_key']);
    }

    /**
     * Set the redirect for when we login.
     * 
     * @param string $path
     */
    public function setLoginRedirect($path)
    {
        $this->login_redirect = $path;

        return $this;
    }

    /**
     * Set the redirect for when we logout.
     * 
     * @param string $path
     */
    public function setLogoutRedirect($path)
    {
        $this->logout_redirect = $path;

        return $this;
    }
}
<?php 

namespace Scaffold\Auth;

use Scaffold\Auth\Adapters\AuthAdapter;
use Scaffold\Session\Adapters\SessionAdapter;
use Scaffold\Session\Session;
use Scaffold\Traits\AdapterPattern;

/**
 * Handle authentication within the application.
 */
class Auth
{   

    use AdapterPattern;

    /**
     * The session instance we're using
     * to keep track of whether the user
     * is logged in or not.
     * 
     * @var Scaffold\Session\Session
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
     * The adapter we're using to store
     * our authentication details. And how
     * we're going to handle it.
     * 
     * @var Scaffold\Auth\Adapters\AuthAdapter
     */
    protected $adapter;

    /**
     * The login redirect url string
     * 
     * @var string
     */
    protected $login_redirect = '';

    /**
     * The logout redirect url string
     * 
     * @var string
     */
    protected $logout_redirect = '';

    /**
     * Construct our authentication system. Allow
     * the session system to be injected if we wish
     * to use something else for it.
     *
     * @param  Scaffold\Auth\Adapters\AuthAdapter $adapter
     * @param  Scaffold\Session\Session|null $session
     */
    public function __construct(AuthAdapter $adapter, Session $session = null)
    {   
        $this->config = config()->get('auth');
        $this->adapter = $adapter;
        $this->session = is_null($session) ? session() : $session;

        $this->adapter->setConfig($this->config);
        $this->adapter->setSession($this->session);

        $this->setLoginRedirect($this->config['login_redirect']);
        $this->setLogoutRedirect($this->config['logout_redirect']);
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

    /**
     * Gets the The login redirect url string.
     *
     * @return string
     */
    public function getLoginRedirect()
    {
        return $this->login_redirect;
    }

    /**
     * Gets the The logout redirect url string.
     *
     * @return string
     */
    public function getLogoutRedirect()
    {
        return $this->logout_redirect;
    }
}
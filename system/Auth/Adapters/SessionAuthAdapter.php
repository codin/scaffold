<?php 

namespace Scaffold\Auth\Adapters;

use Scaffold\Auth\Adapters\AuthAdapter;
use Scaffold\Auth\Authable;
use Scaffold\Exception\NoAuthableLoggedInException;
use Scaffold\Session\Session;

/**
 * Implements system authentication via 
 * the provided session adapter.
 */
class SessionAuthAdapter implements AuthAdapter
{
    /**
     * The config for this adapter.
     * 
     * @var array
     */
    protected $config = [];

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
     * The session instance.
     * 
     * @var Scaffold\Session\Session
     */
    protected $session;

    /**
     * Set the config on this adapter instance, we'll
     * just store it locally in this instance.
     * 
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;

        $this->setLoginRedirect($this->config['login_redirect']);
        $this->setLogoutRedirect($this->config['logout_redirect']);
    }

    /**
     * Set the session instance on this adapter 
     * so we can store the login state for the
     * Authable instances.
     *
     * @param  Session $session
     */
    public function setSession(Session $session)
    {
        $this->session = $session;
    }

    /**
     * Check the users credentials against the database.
     * Login the Authable associated to them if they are
     * correct.
     * 
     * @param  string $username
     * @param  string $password
     * @return Authable|boolean
     */
    public function attempt($username, $password)
    {
        $model = $this->config['authable_model'];

        $user = $model::where('username', $username)
            ->first();

        if (is_null($user) || !password_verify($password, $user->password)) {
            return false;
        }

        return $this->login($user);
    }

    /**
     * Login the Authable to the system, serialize
     * some information about them and store them
     * inside our session. Return the logged in
     * Authable instance.
     * 
     * @param  Authable $authable
     * @return Authable
     */
    public function login(Authable $authable) : Authable
    {
        if ($this->loggedIn()) {
            return $this->retrieveUser();
        }

        $data = $this->session->serialize($authable);

        $this->session->put($this->config['session_key'], $data);

        return $authable;
    }

    /**
     * Logout the currently logged in
     * Authable instance.
     * 
     * @return void
     */
    public function logout()
    {
        $this->session->logout();
    }

    /**
     * Refresh the session for the logged in
     * Authable instance, to extend it's 
     * lifetime.
     * 
     * @return Authable
     */
    public function refresh() : Authable
    {
        $this->session->refresh();

        return $this->user();
    }

    /**
     * Check if there is a current session 
     * logged in.
     * 
     * @return bool
     */
    public function loggedIn() : bool
    {
        return $this->session->has($this->config['session_key']);
    }

    /**
     * Grab the Authable instance for the 
     * currently logged in session, throws
     * an exception if we're not logged in.
     * 
     * @return Authable
     * @throws NoAuthableLoggedInException
     */
    public function user() : Authable
    {
        if (!$this->loggedIn()) {
            throw new NoAuthableLoggedInException;
        }

        return $this->retrieveUser();
    }

    private function retrieveUser() : Authable 
    {
        $data = $this->session->get($this->config['session_key']);

        try {
            $user = $this->session->unserialize($data);

            if (!($user instanceof Authable)) {
                throw new NoAuthableLoggedInException;
            }
            
            $user = $user->fresh();
        } catch (\Exception $e) {
            throw new NoAuthableLoggedInException;
        }

        return $user;
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

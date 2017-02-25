<?php 

namespace Scaffold\Auth\Adapters;

use Scaffold\Auth\Authable;
use Scaffold\Session\Session;

/**
 * Auth interface definition. All authentication
 * methods in Scaffold must implement this interface.
 */
interface AuthAdapter
{
    public function setConfig(array $config);
    public function setSession(Session $session);
    public function attempt($username, $password);
    public function login(Authable $authable) : Authable;
    public function logout();
    public function refresh() : Authable;
    public function loggedIn() : bool;
    public function user() : Authable;
}
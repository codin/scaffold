<?php 

namespace Scaffold\Session\Security;

use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;

/**
 * Our custom interface, using the currently active session system as
 * the storage interface for the csrf tokens in this system.
 */
class CsrfTokenManagerAdapter implements TokenStorageInterface
{
    /**
     * Reads a stored CSRF token.
     *
     * @param string $tokenId The token ID
     *
     * @return string The stored token
     *
     * @throws \Symfony\Component\Security\Csrf\Exception\TokenNotFoundException If the token ID does not exist
     */
    public function getToken($tokenId)
    {
        return session()->get($tokenI);
    }

    /**
     * Stores a CSRF token.
     *
     * @param string $tokenId The token ID
     * @param string $token   The CSRF token
     */
    public function setToken($tokenId, $token)
    {
        return session()->put($tokenId, $token);
    }

    /**
     * Removes a CSRF token.
     *
     * @param string $tokenId The token ID
     *
     * @return string|null Returns the removed token if one existed, NULL
     *                     otherwise
     */
    public function removeToken($tokenId)
    {
        return session()->delete($tokenId);
    }

    /**
     * Checks whether a token with the given token ID exists.
     *
     * @param string $tokenId The token ID
     *
     * @return bool Whether a token exists with the given ID
     */
    public function hasToken($tokenId)
    {
        return session()->has($tokenId);
    }
}
<?php 

namespace Scaffold\Auth;

/**
 * Provide methods we need to implement
 * the Authable interface, allowing us to
 * fake multiple inheritance.
 */
trait AuthableTrait
{   
    /**
     * Serialize the Authable so we can
     * store the information we need
     * to retrieve it.
     * 
     * @return stdClass
     */
    public function serialize() : \stdClass
    {
        return (object)[
            'id' => $this->id
        ];
    }
}
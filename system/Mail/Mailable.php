<?php 

/**
 * Interface to access the data we want to
 * send an email for an entity.
 */
interface Mailable
{
    public function getName() : string;
    public function getEmail() : string;
    public function getPriority() : int;
}
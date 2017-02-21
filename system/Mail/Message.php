<?php 

namespace Scaffold\Mail;

use Scaffold\Mail\Mailable;
use Nette\Mail\Message as NetteMessage;

/**
 * Represent a message to
 * be sent by email.
 */
class Message extends NetteMessage
{   
    /**
     * Construct our message
     * with some parameters.
     *
     * @param  Mailable|null $mailable Optional.
     */
    public function __construct($mailable = null)
    {
        parent::__construct();

        $this->setHeader('X-Mailer', 'Scaffold Framework via Nette');

        if ($mailable instanceof Mailable && $mailable != null) {
            $this->attachMailableToMessage($mailable);
        }
    }

    /**
     * Attach the mailable object to our message.
     * 
     * @param  Scaffold\Mail\Mailable $mailable
     * @return Scaffold\Mail\Message
     */
    protected function attachMailableToMessage(Mailable $mailable)
    {
        $this->setFrom($mailable->getEmail(), $mailable->getName());
        $this->setPriority($mailable->getPriority());
        
        return $this;
    }
}
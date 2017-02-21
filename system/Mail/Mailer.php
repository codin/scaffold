<?php 

namespace Scaffold\Mail;

use Nette\Mail\IMailer as MailerAdapter;
use Scaffold\Traits\AdapterPattern;

/**
 * This is responsible for sending
 * mailable items.
 */
class Mailer
{       
    use AdapterPattern;

    /**
     * The actual handler responsible for
     * sending mail.
     * 
     * @var Nette\Mail\IMailer
     */
    protected $adapter;

    public function __construct(MailerAdapter $mailer)
    {
        $this->adapter = $mailer;
    }
}
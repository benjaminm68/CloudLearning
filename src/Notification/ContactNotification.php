<?php

namespace App\Notification;

use Twig\Environment;
use App\Entity\Contact;
use Symfony\Component\Mailer\Mailer;

class ContactNotification {

    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $renderer;
    
    
    
    
    public function __construct(Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
        
    }

    public function notify(Contact $contact) {

    }

}
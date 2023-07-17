<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{

    private $mailer;
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

 

    public function sendTmpPassword(User $user):void
    {
         $email = (new Email())
            ->from('simobelghali03@gmail.com')
            ->to($user->getEmail())
            ->subject('TMP Password')
            ->text($user->getPassword());

        $this->mailer->send($email);
    }
}


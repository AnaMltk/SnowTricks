<?php

namespace App\Service;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;

class Mailer
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }
    public function sendEmailForAccountActivation($receiver, $url)
    {
        $subject = 'Activation de votre compte';
        $text = 'Cliquez sur le lien pour activer votre compte '.$url;
        $email = (new Email())
            ->from('anastasiamolotkova92@yandex.ru')
            ->to($receiver)
            ->subject($subject)
            ->text($text);

        $this->mailer->send($email);
    }

    public function sendEmailForPasswordReinitialisation($receiver, $url)
    {
        $subject = 'Modification de mot de passe';
        $text = 'Cliquez sur le lien pour modifier votre mot de passe '.$url;
        $email = (new Email())
            ->from('anastasiamolotkova92@yandex.ru')
            ->to($receiver)
            ->subject($subject)
            ->text($text);

        $this->mailer->send($email);
    }
}

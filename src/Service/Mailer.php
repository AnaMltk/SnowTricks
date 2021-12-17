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
    public function sendEmail($receiver, $subject, $text)
    {
        $email = (new Email())
            ->from('anastasiamolotkova92@yandex.ru')
            ->to($receiver)
            ->subject($subject)
            ->text($text);

        $this->mailer->send($email);
    }
}

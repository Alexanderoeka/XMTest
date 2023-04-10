<?php
declare(strict_types=1);


namespace App\Common;


use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailSender
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }


    public function sendEmail(string $fromMail, string $toMail, string $subject, string $bodyHtml)
    {
        $email = (new Email())
            ->from($fromMail)
            ->to($toMail)
            ->subject($subject)
            ->html($bodyHtml);

        $this->mailer->send($email);
        return 'SUCCESS';
    }

}
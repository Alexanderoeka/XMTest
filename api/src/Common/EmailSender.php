<?php
declare(strict_types=1);

namespace App\Common;


use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailSender
{
    private MailerInterface $mailer;


    public function __construct(
        private string $projectMail,
        MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }


    /**
     * @throws TransportExceptionInterface
     */
    public function sendEmail(string $toMail, string $subject, string $bodyHtml): void
    {

        $email = (new Email())
            ->from($this->projectMail)
            ->to($toMail)
            ->subject($subject)
            ->html($bodyHtml);

        $this->mailer->send($email);
    }

}
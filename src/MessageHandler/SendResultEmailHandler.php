<?php

namespace App\MessageHandler;

use App\Message\SendResultEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mime\Email;

class SendResultEmailHandler implements MessageHandlerInterface
{
    private MailerInterface $mailer;
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function __invoke(SendResultEmail $resultEmail)
    {
        $emailAddress   = $resultEmail->resultEmail->getEmail();
        $searchTerm     = $resultEmail->resultEmail->getSearchTerm();
        $html           = $resultEmail->resultEmail->getEmailHtml();

        $email = (new Email())
            ->from('test@test.com')
            ->to($emailAddress)
            ->subject('Here is your '.$searchTerm.' result...')
            ->text("A wild Pokemon appeared")
            ->html($html);

        $this->mailer->send($email);
    }


}
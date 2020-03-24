<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\SwitchUserEvent;
use Symfony\Component\EventDispatcher\GenericEvent;

class MailSubscriber implements EventSubscriberInterface
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function onUserRequestPasswordSuccess(GenericEvent $event)
    {
        $body = $this->renderView('emails/request_password.html.twig', [
            'user' => $event->getSubject()
        ]);

    }

    private function sendEmail($subject, $to, $body)
    {
        $message = (new Swift_Message($subject))
        ->setFrom('send@example.com')
        ->setTo($to)
        ->setBody($body, 'text/html');

        $this->mailer->send($message);
    }

    public static function getSubscribedEvents()
    {
        return [
            'security.reset_password' => 'onUserRequestPasswordSuccess',
        ];
    }
}

<?php

namespace App\EventSubscriber;

use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LoginSubscriber implements EventSubscriberInterface
{
    public function onLoginSuccessEvent(LoginSuccessEvent $event): void
    {
        dump($event) ;
        die('"fin') ;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'LoginSuccessEvent' => 'onLoginSuccessEvent',
        ];
    }
}

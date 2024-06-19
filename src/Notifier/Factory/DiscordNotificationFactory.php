<?php

namespace App\Notifier\Factory;

use App\Notifier\Factory\NotificationFactoryInterface;
use App\Notifier\Notification\DiscordNotification;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Notifier\Recipient\Recipient;

class DiscordNotificationFactory implements NotificationFactoryInterface
{

    public function createNotification(string $email, string $message): ChatMessage
    {
        return (new DiscordNotification())
            ->asChatMessage(new Recipient($email))
            ->subject($message);
    }

    public static function getIndex(): string
    {
        return 'discord';
    }
}

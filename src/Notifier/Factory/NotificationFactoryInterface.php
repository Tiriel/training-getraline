<?php

namespace App\Notifier\Factory;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\Notifier\Message\ChatMessage;

#[AutoconfigureTag('app.notification_factory')]
interface NotificationFactoryInterface
{
    public function createNotification(string $email, string $message): ChatMessage;

    public static function getIndex(): string;
}

<?php

namespace MillCloud\Backup\Notifications;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Notifications\Notification;
use MillCloud\Backup\Events\BackupHasFailed;
use MillCloud\Backup\Events\BackupWasSuccessful;
use MillCloud\Backup\Events\CleanupHasFailed;
use MillCloud\Backup\Events\CleanupWasSuccessful;
use MillCloud\Backup\Events\HealthyBackupWasFound;
use MillCloud\Backup\Events\UnhealthyBackupWasFound;
use MillCloud\Backup\Exceptions\NotificationCouldNotBeSent;

class EventHandler
{
    public function __construct(
        protected Repository $config
    ) {
    }

    public function subscribe(Dispatcher $events): void
    {
        $events->listen($this->allBackupEventClasses(), function ($event) {
            $notifiable = $this->determineNotifiable();

            $notification = $this->determineNotification($event);

            $notifiable->notify($notification);
        });
    }

    protected function determineNotifiable()
    {
        $notifiableClass = $this->config->get('backup.notifications.notifiable');

        return app($notifiableClass);
    }

    protected function determineNotification($event): Notification
    {
        $lookingForNotificationClass = class_basename($event) . "Notification";

        $notificationClass = collect($this->config->get('backup.notifications.notifications'))
            ->keys()
            ->first(fn (string $notificationClass) => class_basename($notificationClass) === $lookingForNotificationClass);

        if (! $notificationClass) {
            throw NotificationCouldNotBeSent::noNotificationClassForEvent($event);
        }

        return new $notificationClass($event);
    }

    protected function allBackupEventClasses(): array
    {
        return [
            BackupHasFailed::class,
            BackupWasSuccessful::class,
            CleanupHasFailed::class,
            CleanupWasSuccessful::class,
            HealthyBackupWasFound::class,
            UnhealthyBackupWasFound::class,
        ];
    }
}

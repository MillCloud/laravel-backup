<?php

namespace MillCloud\Backup;

use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use MillCloud\Backup\Commands\BackupCommand;
use MillCloud\Backup\Commands\CleanupCommand;
use MillCloud\Backup\Commands\ListCommand;
use MillCloud\Backup\Commands\MonitorCommand;
use MillCloud\Backup\Events\BackupHasFailed;
use MillCloud\Backup\Events\BackupZipWasCreated;
use MillCloud\Backup\Events\BackupWasSuccessful;
use MillCloud\Backup\Helpers\ConsoleOutput;
use MillCloud\Backup\Listeners\BackupHasFailedListener;
use MillCloud\Backup\Listeners\BackupWasSuccessfulListener;
use MillCloud\Backup\Listeners\EncryptBackupArchive;
use MillCloud\Backup\Notifications\Channels\Discord\DiscordChannel;
use MillCloud\Backup\Notifications\EventHandler;
use MillCloud\Backup\Tasks\Cleanup\CleanupStrategy;
use MillCloud\LaravelPackageTools\Package;
use MillCloud\LaravelPackageTools\PackageServiceProvider;
use function Symfony\Component\Translation\t;

class BackupServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-backup')
            ->hasConfigFile()
            ->hasTranslations()
            ->hasCommands([
                BackupCommand::class,
                CleanupCommand::class,
                ListCommand::class,
                MonitorCommand::class,
            ]);

        // alter sdw
        $package->hasMigrations([
            'create_backup_logs_table'
        ])->runsMigrations();
        // alter end
    }

    public function packageBooted()
    {
        $this->app['events']->subscribe(EventHandler::class);

        if (EncryptBackupArchive::shouldEncrypt()) {
            Event::listen(BackupZipWasCreated::class, EncryptBackupArchive::class);
        }

        // alter sdw
        Event::listen(BackupWasSuccessful::class,BackupWasSuccessfulListener::class);
        Event::listen(BackupHasFailed::class,BackupHasFailedListener::class);
        // alter end

    }

    public function packageRegistered()
    {
        $this->app->singleton(ConsoleOutput::class);

        $this->app->bind(CleanupStrategy::class, config('backup.cleanup.strategy'));

        $this->registerDiscordChannel();
    }

    protected function registerDiscordChannel()
    {
        Notification::resolved(function (ChannelManager $service) {
            $service->extend('discord', function ($app) {
                return new DiscordChannel();
            });
        });
    }
}

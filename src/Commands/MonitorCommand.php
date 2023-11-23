<?php

namespace MillCloud\Backup\Commands;

use MillCloud\Backup\Events\HealthyBackupWasFound;
use MillCloud\Backup\Events\UnhealthyBackupWasFound;
use MillCloud\Backup\Tasks\Monitor\BackupDestinationStatusFactory;

class MonitorCommand extends BaseCommand
{
    /** @var string */
    protected $signature = 'backup:monitor';

    /** @var string */
    protected $description = 'Monitor the health of all backups.';

    public function handle(): int
    {
        if (config()->has('backup.monitorBackups')) {
            $this->warn("Warning! Your config file still uses the old monitorBackups key. Update it to monitor_backups.");
        }

        $hasError = false;

        $statuses = BackupDestinationStatusFactory::createForMonitorConfig(config('backup.monitor_backups'));

        foreach ($statuses as $backupDestinationStatus) {
            $backupName = $backupDestinationStatus->backupDestination()->backupName();
            $diskName = $backupDestinationStatus->backupDestination()->diskName();

            if ($backupDestinationStatus->isHealthy()) {
                $this->info("The {$backupName} backups on the {$diskName} disk are considered healthy.");
                event(new HealthyBackupWasFound($backupDestinationStatus));
            } else {
                $hasError = true;
                $this->error("The {$backupName} backups on the {$diskName} disk are considered unhealthy!");
                event(new UnhealthyBackupWasFound($backupDestinationStatus));
            }
        }

        if ($hasError) {
            return static::FAILURE;
        }

        return static::SUCCESS;
    }
}

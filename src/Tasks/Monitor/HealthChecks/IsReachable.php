<?php

namespace MillCloud\Backup\Tasks\Monitor\HealthChecks;

use MillCloud\Backup\BackupDestination\BackupDestination;
use MillCloud\Backup\Tasks\Monitor\HealthCheck;

class IsReachable extends HealthCheck
{
    public function checkHealth(BackupDestination $backupDestination): void
    {
        $this->failUnless(
            $backupDestination->isReachable(),
            trans('backup::notifications.unhealthy_backup_found_not_reachable', [
                'error' => $backupDestination->connectionError,
            ])
        );
    }
}

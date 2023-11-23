<?php

namespace MillCloud\Backup\Events;

use MillCloud\Backup\Tasks\Monitor\BackupDestinationStatus;

class HealthyBackupWasFound
{
    public function __construct(
        public BackupDestinationStatus $backupDestinationStatus,
    ) {
    }
}

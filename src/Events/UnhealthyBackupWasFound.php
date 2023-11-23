<?php

namespace MillCloud\Backup\Events;

use MillCloud\Backup\Tasks\Monitor\BackupDestinationStatus;

class UnhealthyBackupWasFound
{
    public function __construct(
        public BackupDestinationStatus $backupDestinationStatus
    ) {
    }
}

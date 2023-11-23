<?php

namespace MillCloud\Backup\Events;

use MillCloud\Backup\BackupDestination\BackupDestination;

class CleanupWasSuccessful
{
    public function __construct(
        public BackupDestination $backupDestination,
    ) {
    }
}

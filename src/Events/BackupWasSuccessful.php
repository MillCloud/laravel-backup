<?php

namespace MillCloud\Backup\Events;

use MillCloud\Backup\BackupDestination\BackupDestination;

class BackupWasSuccessful
{
    public function __construct(
        public BackupDestination $backupDestination,
    ) {
    }
}

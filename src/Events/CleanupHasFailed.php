<?php

namespace MillCloud\Backup\Events;

use Exception;
use MillCloud\Backup\BackupDestination\BackupDestination;

class CleanupHasFailed
{
    public function __construct(
        public Exception $exception,
        public ?BackupDestination $backupDestination = null,
    ) {
    }
}

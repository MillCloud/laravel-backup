<?php

namespace MillCloud\Backup\Events;

use Exception;
use MillCloud\Backup\BackupDestination\BackupDestination;

class BackupHasFailed
{
    public function __construct(
        public Exception $exception,
        public ?BackupDestination $backupDestination = null,
    ) {
    }
}

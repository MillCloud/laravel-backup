<?php

namespace MillCloud\Backup\Listeners;

use MillCloud\Backup\Models\BackupLogs;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use MillCloud\Backup\Events\BackupHasFailed;

class BackupHasFailedListener
{
    public function handle(BackupHasFailed $event): void
    {
//        $use = $event->backupDestination->useTime();
        $use = 0;

        BackupLogs::create([
            'name' => '',
            'type' => 'auto',
            'status' =>  0,
            'file_size' => 0,
            'file_path' => '',
            'used' => $use,
            'reason' => $event->exception->getMessage(),
        ]);
    }
}

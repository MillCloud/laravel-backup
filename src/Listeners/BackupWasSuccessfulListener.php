<?php

namespace MillCloud\Backup\Listeners;

use MillCloud\Backup\Models\BackupLogs;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use MillCloud\Backup\Events\BackupWasSuccessful;

class BackupWasSuccessfulListener
{

    /**
     * Handle the event.
     */
    public function handle(BackupWasSuccessful $event): void
    {
        $filename = $event->backupDestination->filename();
        $filesize = $event->backupDestination->newestBackup()->sizeInBytes();
        $filepath = $event->backupDestination->backupName().'/'.$filename;
        $use = $event->backupDestination->useTime();

        BackupLogs::create([
            'name' => $filename,
            'type' => 'auto',
            'file_size' => $filesize,
            'file_path' => $filepath,
            'used' => $use,
        ]);
    }

}

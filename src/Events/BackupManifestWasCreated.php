<?php

namespace MillCloud\Backup\Events;

use MillCloud\Backup\Tasks\Backup\Manifest;

class BackupManifestWasCreated
{
    public function __construct(
        public Manifest $manifest,
    ) {
    }
}

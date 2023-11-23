<?php

namespace MillCloud\Backup\Events;

class BackupZipWasCreated
{
    public function __construct(
        public string $pathToZip,
    ) {
    }
}

<?php

namespace MillCloud\Backup\Events;

use MillCloud\DbDumper\DbDumper;

class DumpingDatabase
{
    public function __construct(
        public DbDumper $dbDumper
    ) {
    }
}

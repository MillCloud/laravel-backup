<?php

use MillCloud\Backup\Helpers\ConsoleOutput;

function consoleOutput(): ConsoleOutput
{
    return app(ConsoleOutput::class);
}

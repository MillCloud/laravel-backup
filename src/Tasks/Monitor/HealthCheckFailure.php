<?php

namespace MillCloud\Backup\Tasks\Monitor;

use Exception;
use MillCloud\Backup\Exceptions\InvalidHealthCheck;

class HealthCheckFailure
{
    public function __construct(
        protected HealthCheck $healthCheck,
        protected Exception $exception
    ) {
    }

    public function healthCheck(): HealthCheck
    {
        return $this->healthCheck;
    }

    public function exception(): Exception
    {
        return $this->exception;
    }

    public function wasUnexpected(): bool
    {
        return ! $this->exception instanceof InvalidHealthCheck;
    }
}

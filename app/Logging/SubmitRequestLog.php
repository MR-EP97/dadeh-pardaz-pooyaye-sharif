<?php

namespace App\Logging;

use Monolog\Handler\StreamHandler;

class SubmitRequestLog
{
    public function __invoke($logger): void
    {
        $date = date('Y-m-d');
        new StreamHandler(storage_path("logs/submit-request-{$date}.log"));
    }
}

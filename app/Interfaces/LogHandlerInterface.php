<?php
declare(strict_types=1);

namespace App\Interfaces;

use App\DTOs\LogData;

interface LogHandlerInterface
{
    /**
     * Handle the log data.
     */
    public function handle(LogData $logData): void;

}
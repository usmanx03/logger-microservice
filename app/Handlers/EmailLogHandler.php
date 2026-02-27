<?php

declare(strict_types=1);

namespace App\Handlers;

use App\DTOs\LogData;
use App\Enums\LogSeverity;
use App\Interfaces\LogHandlerInterface;

class EmailLogHandler implements LogHandlerInterface
{
    public function handle(LogData $logData): void
    {
        // TODO: implement Email logging
    }

    public function getSupportedSeverities(): array
    {
        return [
            LogSeverity::CRITICAL->value,
        ];
    }
}
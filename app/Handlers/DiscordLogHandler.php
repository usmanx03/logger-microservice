<?php

declare(strict_types=1);

namespace App\Handlers;

use App\DTOs\LogData;
use App\Enums\LogSeverity;
use App\Interfaces\LogHandlerInterface;

class DiscordLogHandler implements LogHandlerInterface
{
    public function handle(LogData $logData): void
    {
        // TODO: implement Discord logging
    }

    public function getSupportedSeverities(): array
    {
        return [
            LogSeverity::ERROR->value,
            LogSeverity::CRITICAL->value,
        ];
    }
}
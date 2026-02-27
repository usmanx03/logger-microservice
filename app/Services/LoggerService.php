<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\LogData;
use App\Enums\LogSeverity;
use App\Handlers\DiscordLogHandler;
use App\Handlers\EmailLogHandler;
use App\Handlers\FileLogHandler;
use App\Handlers\SlackLogHandler;
use App\Interfaces\LogHandlerInterface;
use Exception;

class LoggerService
{
    /**
     * Map severity values to handler classes
     */
    private array $severityHandlerMap = [
        LogSeverity::DEBUG->value => [
            FileLogHandler::class,
        ],
        LogSeverity::INFO->value => [
            FileLogHandler::class,
        ],
        LogSeverity::WARNING->value => [
            FileLogHandler::class,
        ],
        LogSeverity::ERROR->value => [
            FileLogHandler::class,
            SlackLogHandler::class,
            DiscordLogHandler::class,
        ],
        LogSeverity::CRITICAL->value => [
            FileLogHandler::class,
            SlackLogHandler::class,
            DiscordLogHandler::class,
            EmailLogHandler::class,
        ],
    ];

    /**
     * Log data dynamically using severity
     */
    public function log(LogData $logData): bool
    {
        $handlers = $this->resolveHandlers($logData->severity->value);

        $allSuccess = true;

        foreach ($handlers as $handler) {
            try {
                $handler->handle($logData);
            } catch (Exception $e) {
                $allSuccess = false;
            }
        }

        return $allSuccess;
    }

    /**
     * Instantiate handlers dynamically based on severity value
     *
     * @param string $severityValue
     * @return LogHandlerInterface[]
     */
    private function resolveHandlers(string $severityValue): array
    {
        $handlers = [];

        $classes = $this->severityHandlerMap[$severityValue] ?? [];

        foreach ($classes as $class) {
            if (class_exists($class)) {
                $handlers[] = new $class();
            }
        }

        return $handlers;
    }
}
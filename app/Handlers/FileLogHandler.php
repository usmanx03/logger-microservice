<?php

declare(strict_types=1);

namespace App\Handlers;

use App\DTOs\LogData;
use App\Enums\LogSeverity;
use App\Helpers\Config;
use App\Interfaces\LogHandlerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;

class FileLogHandler implements LogHandlerInterface
{
    private Logger $logger;

    public function __construct()
    {
        $this->logger = new Logger('file');
    }

    public function handle(LogData $logData): void
    {
        // Get environment-specific path from config
        $envPath = Config::get("handlers.file.{$logData->env->value}.path", '/production');

        // Full directory: STORAGE_PATH/logs/{app}/{environment}
        $dir = STORAGE_PATH . '/logs/' . $logData->app . $envPath;

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        // Daily log file
        $filename = date('Y-m-d') . '.log';
        $filepath = $dir . "/$filename";

        // Reset handlers to ensure correct file
        $this->logger->setHandlers([]);
        $this->logger->pushHandler(
            new StreamHandler($filepath, $this->mapSeverityToMonologLevel($logData->severity))
        );

        $this->logger->log(
            $this->mapSeverityToMonologLevel($logData->severity),
            $logData->message,
            array_merge($logData->context, [
                'trace' => $logData->trace,
                'app' => $logData->app,
                'env' => $logData->env->value,
            ])
        );
    }

    private function mapSeverityToMonologLevel(LogSeverity $severity): Level
    {
        return match ($severity) {
            LogSeverity::DEBUG => Level::Debug,
            LogSeverity::INFO => Level::Info,
            LogSeverity::WARNING => Level::Warning,
            LogSeverity::ERROR => Level::Error,
            LogSeverity::CRITICAL => Level::Critical,
        };
    }
}
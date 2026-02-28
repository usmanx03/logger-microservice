<?php

declare(strict_types=1);

namespace App\Handlers;

use App\DTOs\LogData;
use App\Helpers\Config;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class FileLogHandler extends AbstractLogHandler
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
}
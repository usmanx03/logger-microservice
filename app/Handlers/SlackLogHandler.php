<?php

declare(strict_types=1);

namespace App\Handlers;

use App\DTOs\LogData;
use App\Helpers\Config;
use Monolog\Handler\SlackWebhookHandler;
use Monolog\Level;
use Monolog\Logger;

class SlackLogHandler extends AbstractLogHandler
{
    public function handle(LogData $logData): void
    {
        $env = $logData->env->value;

        // Resolve webhook using env from request payload
        $webhookUrl = Config::get("handlers.slack.$env.webhook_url");

        if (empty($webhookUrl)) {
            throw new \RuntimeException("Slack webhook not configured for env: $env");
        }

        $logger = new Logger('slack');
        $logger->pushHandler(
            new SlackWebhookHandler(
                $webhookUrl,
                null,
                null,
                true,
                null,
                true,
                false,
                Level::Error
            )
        );

        $level = $this->mapSeverityToMonologLevel($logData->severity);

        $logger->log(
            $level,
            $logData->message,
            array_merge($logData->context, [
                'trace' => $logData->trace,
                'app' => $logData->app,
                'env' => $env,
            ])
        );
    }
}
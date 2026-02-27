<?php
declare(strict_types=1);

namespace App\Handlers;

use App\DTOs\LogData;
use App\Enums\LogSeverity;
use App\Interfaces\LogHandlerInterface;
use Monolog\Logger;
use Monolog\Handler\SlackWebhookHandler;
use Monolog\Level;
use App\Helpers\Config;

class SlackLogHandler implements LogHandlerInterface
{
    private Logger $logger;

    public function __construct()
    {
        // Get Slack webhook dynamically from Config helper
        $env = Config::get('app.env', 'production');
        $webhookUrl = Config::get("handlers.slack.{$env}.webhook_url", '');

        if (empty($webhookUrl)) {
            throw new \RuntimeException('Slack webhook URL is not configured in ENV');
        }

        $this->logger = new Logger('slack');
        $this->logger->pushHandler(
            new SlackWebhookHandler(
                $webhookUrl,
                null,   // channel is pre-configured in Slack
                null,   // username is pre-configured
                true,   // use attachment
                null,   // icon emoji
                true,   // short attachment
                false,  // include context and extra
                Level::Error // minimum level
            )
        );
    }

    public function handle(LogData $logData): void
    {
        $level = $this->mapSeverityToMonologLevel($logData->severity);

        $this->logger->log(
            $level,
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
<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Enums\LogSeverity;
use App\Interfaces\LogHandlerInterface;
use Monolog\Level;

abstract class AbstractLogHandler implements LogHandlerInterface
{
    protected function mapSeverityToMonologLevel(LogSeverity $severity): Level
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
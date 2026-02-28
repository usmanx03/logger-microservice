<?php
declare(strict_types=1);

namespace App\Enums;

enum LogSeverity: string
{
    case DEBUG = 'debug';
    case INFO = 'info';
    case WARNING = 'warning';
    case ERROR = 'error';
    case CRITICAL = 'critical';
}
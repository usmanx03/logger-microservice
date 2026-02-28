<?php

declare(strict_types=1);

namespace App\Enums;

enum LogEnv: string
{
    case PRODUCTION = 'production';
    case STAGING = 'staging';
    case DEBUG = 'debug';
}
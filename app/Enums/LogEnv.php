<?php

declare(strict_types=1);

namespace app\Enums;

enum LogEnv: string
{
    case PROD = 'PROD';
    case STAGING = 'STAGING';
    case DEBUG = 'DEBUG';
}
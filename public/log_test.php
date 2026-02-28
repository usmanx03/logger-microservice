<?php

declare(strict_types=1);

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . "/vendor/autoload.php";

$logger = new Logger('main');

$handler = new StreamHandler(BASE_PATH . '/storage/logs/app.log', Level::Info);
$handler->setFormatter(new LineFormatter(ignoreEmptyContextAndExtra: true));

$logger->pushHandler($handler);

$logger->info("Payment successful! Amount is $20");

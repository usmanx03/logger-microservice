<?php

declare(strict_types=1);

use App\Controllers\LoggerController;
use DI\Container;
use Dotenv\Dotenv;
use Slim\Factory\AppFactory;

require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/bootstrap/bootstrap.php';

// .env
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// Dependency Injection
$container = new Container();
AppFactory::setContainer($container);

// Start the application
$app = AppFactory::create();
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();

// Routing
$app->post('/log', [LoggerController::class, 'log']);

$app->run();
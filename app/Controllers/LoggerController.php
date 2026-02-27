<?php

declare(strict_types=1);

namespace App\Controllers;

use App\DTOs\LogData;
use App\Services\LoggerService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class LoggerController extends AbstractController
{
    public function __construct(
        private readonly LoggerService $loggerService,
    ) {
        //
    }

    public function log(Request $request, Response $response, array $args): Response
    {
        $logData = $this->resolveLogDataFromRequest($request);

        $success = $this->loggerService->log($logData);

        $response->getBody()->write("Logs handled: $success");
        return $response;
    }

    protected function resolveLogDataFromRequest(Request $request): LogData
    {
        return LogData::fromRequest($request);
    }
}
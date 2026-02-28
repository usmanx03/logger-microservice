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

        $_ = $this->loggerService->log($logData);

        $response = $response->withHeader('Content-type', 'application/json');
        $response->getBody()->write(json_encode([
            "message" => "Success",
        ]));

        return $response;
    }

    protected function resolveLogDataFromRequest(Request $request): LogData
    {
        return LogData::fromRequest($request);
    }
}
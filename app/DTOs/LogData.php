<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enums\LogEnv;
use App\Enums\LogSeverity;
use Psr\Http\Message\ServerRequestInterface as Request;

class LogData
{
    public string $app;
    public LogEnv $env;
    public LogSeverity $severity;
    public string $message;
    public array $context = [];
    public array $trace = [];

    /**
     * Build LogData from PSR-7 ServerRequest (POST body)
     */
    public static function fromRequest(Request $request): self
    {
        $data = $request->getParsedBody() ?? [];

        var_dump($data);

        $log = new self();

        $log->app = $data['app'] ?? "Unknown-app";

        $envStr = strtoupper($data['env'] ?? 'PROD');
        $log->env = LogEnv::tryFrom($envStr) ?? LogEnv::PROD;

        $severityStr = strtoupper($data['severity'] ?? 'INFO');
        var_dump($severityStr);exit(); // TODO: Enums must have uppercase keys and lower case strings
        $log->severity = LogSeverity::tryFrom($severityStr) ?? LogSeverity::INFO;

        $log->message = $data['message'] ?? "No message received";
        $log->context = $data['context'] ?? [];
        $log->trace = $data['trace'] ?? [];

        var_dump($log);
        exit();

        return $log;
    }
}
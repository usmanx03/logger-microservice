<?php

declare(strict_types=1);

return [
    'file' => [
        'production' => [
            'path' => '/production',
        ],
        'staging' => [
            'path' => '/staging',
        ],
        'debug' => [
            'path' => '/debug',
        ],
    ],
    'slack' => [
        'production' => [
            'webhook_url' => $_ENV['SLACK_PROD_WEBHOOK_URL'] ?? '',
            'channel' => $_ENV['SLACK_PROD_CHANNEL'] ?? '#none',
            'username' => $_ENV['SLACK_PROD_USERNAME'] ?? 'none',
        ],
        'staging' => [
            'webhook_url' => $_ENV['SLACK_STAGING_WEBHOOK_URL'] ?? '',
            'channel' => $_ENV['SLACK_STAGING_CHANNEL'] ?? '#none',
            'username' => $_ENV['SLACK_STAGING_USERNAME'] ?? 'none',
        ],
        'debug' => [
            'webhook_url' => $_ENV['SLACK_DEBUG_WEBHOOK_URL'] ?? '',
            'channel' => $_ENV['SLACK_DEBUG_CHANNEL'] ?? '#none',
            'username' => $_ENV['SLACK_DEBUG_USERNAME'] ?? 'none',
        ],
    ],
];
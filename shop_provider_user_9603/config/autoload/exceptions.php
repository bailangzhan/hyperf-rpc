<?php

declare(strict_types=1);
return [
    'handler' => [
        'jsonrpc-http' => [
            App\Exception\Handler\JsonRpcExceptionHandler::class,
        ],
    ],
];

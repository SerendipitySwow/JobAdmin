<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

return [
    'handler' => [
        'http' => [
            Hyperf\Validation\ValidationExceptionHandler::class,
            Mine\Exception\Handler\NoPermissionExceptionHandler::class,
            Mine\Exception\Handler\NoPermissionExceptionHandler::class,
            Hyperf\HttpServer\Exception\Handler\HttpExceptionHandler::class,
            Mine\Exception\Handler\AppExceptionHandler::class,
        ],
    ],
];

<?php

declare(strict_types=1);
namespace App\Exception\Handler;

use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class AppExceptionHandler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        // 格式化输出
        $data = json_encode([
            'code' => $throwable->getCode(),
            'message' => $throwable->getMessage(),
        ], JSON_UNESCAPED_UNICODE);

        // 阻止异常冒泡
        $this->stopPropagation();

        return $response
            ->withAddedHeader('Content-Type', ' application/json; charset=UTF-8')
            ->withStatus(500)
            ->withBody(new SwooleStream($data));

        //return $response->withHeader('Server', 'Hyperf')->withStatus(500)->withBody(new SwooleStream('Internal Server Error.'));
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}

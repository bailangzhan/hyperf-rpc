<?php

declare(strict_types=1);

namespace App\CircuitBreaker;

use Bailangzhan\Result\Result;
use Hyperf\CircuitBreaker\FallbackInterface;
use Hyperf\Di\Aop\ProceedingJoinPoint;

class GlobalFallback implements FallbackInterface
{
    /**
     * @param ProceedingJoinPoint $proceedingJoinPoint
     * @return array
     */
    public function fallback(ProceedingJoinPoint $proceedingJoinPoint)
    {
        return Result::error("[全局提示]服务器繁忙！");
    }
}

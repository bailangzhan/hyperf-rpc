<?php

declare(strict_types=1);

return [
    // 每秒生成令牌数
    'create' => 1,
    // 每次请求消耗令牌数
    'consume' => 1,
    // 令牌桶最大容量
    'capacity' => 2,
    // 触发限流时回调方法
    'limitCallback' => [],
    // 排队超时时间，至少是1秒
    'waitTimeout' => 1,
];

<?php

declare(strict_types=1);

use Hyperf\Metric\Adapter\Prometheus\Constants;

return [
    // metrics 驱动，默认是 prometheus
    'default' => env('METRIC_DRIVER', 'prometheus'),
    // 使用独立进程监控
    'use_standalone_process' => env('METRIC_USE_STANDALONE_PROCESS', true),
    // 是否统计默认指标。默认指标包括内存占用、系统 CPU 负载以及 Swoole Server 指标和 Swoole Coroutine 指标。
    // 选择 true
    'enable_default_metric' => env('METRIC_ENABLE_DEFAULT_METRIC', true),
    // 默认指标推送周期为5秒
    'default_metric_interval' => env('DEFAULT_METRIC_INTERVAL', 5),
    'metric' => [
        // promethues 配置
        'prometheus' => [
            'driver' => Hyperf\Metric\Adapter\Prometheus\MetricFactory::class,
            // Prometheus 有两种工作模式，爬模式 Constants::SCRAPE_MODE 与推模式 Constants::PUSH_MODE
            // 推荐使用 Constants::SCRAPE_MODE
            'mode' => Constants::SCRAPE_MODE,
            'namespace' => env('APP_NAME', 'skeleton'),
            'scrape_host' => env('PROMETHEUS_SCRAPE_HOST', '0.0.0.0'),
            'scrape_port' => env('PROMETHEUS_SCRAPE_PORT', '9503'),
            'scrape_path' => env('PROMETHEUS_SCRAPE_PATH', '/metrics'),
//            'push_host' => env('PROMETHEUS_PUSH_HOST', '0.0.0.0'),
//            'push_port' => env('PROMETHEUS_PUSH_PORT', '9091'),
//            'push_interval' => env('PROMETHEUS_PUSH_INTERVAL', 5),
        ],
//        'statsd' => [
//            'driver' => Hyperf\Metric\Adapter\StatsD\MetricFactory::class,
//            'namespace' => env('APP_NAME', 'skeleton'),
//            'udp_host' => env('STATSD_UDP_HOST', '127.0.0.1'),
//            'udp_port' => env('STATSD_UDP_PORT', '8125'),
//            'enable_batch' => env('STATSD_ENABLE_BATCH', true),
//            'push_interval' => env('STATSD_PUSH_INTERVAL', 5),
//            'sample_rate' => env('STATSD_SAMPLE_RATE', 1.0),
//        ],
//        'influxdb' => [
//            'driver' => Hyperf\Metric\Adapter\InfluxDB\MetricFactory::class,
//            'namespace' => env('APP_NAME', 'skeleton'),
//            'host' => env('INFLUXDB_HOST', '127.0.0.1'),
//            'port' => env('INFLUXDB_PORT', '8086'),
//            'username' => env('INFLUXDB_USERNAME', ''),
//            'password' => env('INFLUXDB_PASSWORD', ''),
//            'dbname' => env('INFLUXDB_DBNAME', true),
//            'push_interval' => env('INFLUXDB_PUSH_INTERVAL', 5),
//            'auto_create_db' => env('INFLUXDB_AUTO_CREATE_DB', true),
//        ],
//        'noop' => [
//            'driver' => Hyperf\Metric\Adapter\NoOp\MetricFactory::class,
//        ],
    ],
];

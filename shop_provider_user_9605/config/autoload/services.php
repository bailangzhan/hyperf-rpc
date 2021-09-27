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
    // 是否开启服务发现和服务注册，这两个选项应该是提前预留，暂时没有什么用，设置false也会开启
    'enable' => [
        'discovery' => true,
        'register' => true,
    ],
    // 服务消费者配置，这个大家应该都很熟悉，我们在shop_consumer_user服务内配置过
    'consumers' => [],
    // 服务提供者配置，服务提供者官方暂时（2021-09-11）不支持通过配置项进行配置，目前还只支持注解的形式定义
    'providers' => [],
    // 服务驱动，目前只支持consul和nacos，nacos我们后续说
    'drivers' => [
        // consul 配置
        'consul' => [
            // 服务中心地址，我们本地开启的8500端口，不做修改
            'uri' => 'http://127.0.0.1:8500',
            // Access Control List, 即consul权限控制所需要的token，consul默认没有开启ACL，所以不需要配置token
            'token' => '',
            // 健康检查相关配置
            'check' => [
                // 服务注销时间, 如果consul服务90分钟没有收到心跳检测，那么consul就会从注册中心剔除当前关联的所有服务，
                // 默认90分钟，最小超时时间1分钟
                'deregister_critical_service_after' => '90m',
                // 健康检查的时间，暂定1s检查一次
                'interval' => '1s',
            ],
        ],
        'nacos' => [
            // nacos server url like https://nacos.hyperf.io, Priority is higher than host:port
            // 'url' => '',
            // The nacos host info
            'host' => '127.0.0.1',
            'port' => 8848,
            // 登录 nacos 平台的账户密码
            'username' => 'nacos',
            'password' => 'nacos',
            'guzzle' => [
                'config' => null,
            ],
            // 分组名
            'group_name' => 'DEFAULT_GROUP',
            // 命名空间id
            'namespace_id' => 'hyperf',
            'heartbeat' => 5,
        ],
    ],
];

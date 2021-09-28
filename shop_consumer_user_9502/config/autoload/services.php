<?php

// 服务定义
$consumerServices = [
    'UserService' => \App\JsonRpc\UserServiceInterface::class,
];

return [
    // 是否开启服务发现和服务注册，这两个选项应该是提前预留，暂时没有什么用，设置false也会开启
    'enable' => [
        'discovery' => true,
        'register' => true,
    ],
    // 服务提供者配置，服务提供者官方暂时（2021-09-28）不支持通过配置项进行配置，目前还只支持注解的形式定义
    'providers' => [],
    // 服务消费者配置
    'consumers' => value(function () use ($consumerServices) {
        $consumers = [];
        foreach ($consumerServices as $name => $interface) {
            $consumers[] = [
                'name' => $name,
                'service' => $interface,
                // 负载均衡算法，我们选择轮询
                'load_balancer' => 'round-robin',
                // 这个消费者要从哪个服务中心获取节点信息，如不配置则不会从服务中心获取节点信息
                'registry' => [
                    'protocol' => 'nacos',
                    'address' => 'http://127.0.0.1:8848',
                ],
                // nodes配置可以不注册，为了确认是从nacos获取的节点信息，这里先屏蔽
                // 'nodes' => [
                //    ['host' => '127.0.0.1', 'port' => 9600],
                //],
            ];
        }
        return $consumers;
    }),

    // 服务驱动，配置 nacos
    'drivers' => [
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
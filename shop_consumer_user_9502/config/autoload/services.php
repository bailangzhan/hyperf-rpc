<?php

// 服务定义
$consumerServices = [
    'UserService' => \App\JsonRpc\UserServiceInterface::class,
];

return [
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
                // nodes配置可以不注册，为了确认是从consul获取的节点信息，这里先屏蔽
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

//return [
//    'consumers' => [
//        [
//            // 对应消费者类的 $serviceName
//            'name' => 'UserService',
//            // 服务接口名，可选，默认值等于 name 配置的值，如果 name 直接定义为接口类则可忽略此行配置，
//            // 如 name 为字符串则需要配置 service 对应到接口类
//            'service' => \App\JsonRpc\UserServiceInterface::class,
//            // 默认是 jsonrpc-http 协议
//            'protocol' => 'jsonrpc-http',
//            // 直接对指定的节点进行消费，通过下面的 nodes 参数来配置服务提供者的节点信息
//            'nodes' => [
//                ['host' => '127.0.0.1', 'port' => 9600],
//            ],
//        ]
//    ],
//];
<?php

namespace App\JsonRpc;

use Hyperf\RpcClient\AbstractServiceClient;

class UserService extends AbstractServiceClient implements UserServiceInterface
{
    /**
     * 定义对应服务提供者的服务名称
     * @var string
     */
    protected $serviceName = 'UserService';

    /**
     * 定义对应服务提供者的服务协议
     * @var string
     */
    protected $protocol = 'jsonrpc-http';

    /**
     * @param string $name
     * @param int $gender
     * @return mixed
     */
    public function createUser(string $name, int $gender)
    {
        return $this->__request(__FUNCTION__, compact('name', 'gender'));
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getUserInfo(int $id)
    {
        var_dump(__METHOD__);
        return $this->__request(__FUNCTION__, compact('id'));
    }
}




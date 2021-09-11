<?php

namespace App\JsonRpc;

use App\Model\User;
use App\Tools\Result;
use Hyperf\RpcServer\Annotation\RpcService;
use Hyperf\ServiceGovernanceConsul\ConsulAgent;
use Hyperf\Utils\ApplicationContext;

/**
 * @RpcService(name="UserService", protocol="jsonrpc-http", server="jsonrpc-http", publishTo="consul")
 */
class UserService implements UserServiceInterface
{
    /**
     * @param string $name
     * @param int $gender
     * @return array
     */
    public function createUser(string $name, int $gender)
    {
        if (empty($name)) {
            throw new \RuntimeException("name不能为空");
        }

        $result = User::query()->create([
            'name' => $name,
            'gender' => $gender,
        ]);
        return $result ? Result::success() : Result::error("fail");
    }

    /**
     * @param int $id
     * @return array
     */
    public function getUserInfo(int $id)
    {
//        foo();
        $user = User::query()->find($id);
        if (empty($user)) {
            throw new \RuntimeException("user not found");
        }
//        return $user->toArray();
        return \Bailangzhan\Result\Result::success($user->toArray());
    }

    /**
     * @return array
     */
    public function test()
    {
        $agent = ApplicationContext::getContainer()->get(ConsulAgent::class);

        // 手动注销服务
        // $agent->deregisterService('UserService-0');

        return \Bailangzhan\Result\Result::success([
            // 已注册的服务
            'services' => $agent->services()->json(),
            // 健康状态检查
            'checks' => $agent->checks()->json(),
        ]);
    }
}




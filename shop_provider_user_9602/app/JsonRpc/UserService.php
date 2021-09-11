<?php

namespace App\JsonRpc;

use App\Model\User;
use App\Tools\Result;
use Hyperf\Contract\ConfigInterface;
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
        $port = null;
        $config = ApplicationContext::getContainer()->get(ConfigInterface::class);
        $servers = $config->get('server.servers');
        $appName = $config->get('app_name');
        foreach ($servers as $k => $server) {
            if ($server['name'] == 'jsonrpc-http') {
                $port = $server['port'];
                break;
            }
        }

        return \Bailangzhan\Result\Result::success([
            'appName' => $appName,
            'port' => $port,
        ]);
    }
}




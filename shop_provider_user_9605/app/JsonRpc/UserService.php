<?php

namespace App\JsonRpc;

use App\Model\User;
use Hyperf\Cache\Annotation\Cacheable;
use Hyperf\CircuitBreaker\Annotation\CircuitBreaker;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\RateLimit\Annotation\RateLimit;
use Hyperf\RateLimit\Exception\RateLimitException;
use Hyperf\RpcServer\Annotation\RpcService;
use Hyperf\ServiceGovernanceConsul\ConsulAgent;
use Hyperf\ServiceGovernanceNacos\Client;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Utils\Codec\Json;
use Bailangzhan\Result\Result;

/**
 * @RpcService(name="UserService", protocol="jsonrpc-http", server="jsonrpc-http", publishTo="nacos")
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
     * @RateLimit(create=1, consume=1, capacity=1, waitTimeout=10, limitCallback={UserService::class, "limitCallback"})
     * create=1, 每秒生成1个令牌
     * consume=1, 每个请求每次消耗1个令牌
     * capacity=1, 令牌桶最大是1
     * waitTimeout=1, 超时时间设置为1秒，QPS超过1时，请求会排队等待，超时会执行 limitCallback 指定的回调方法
     * limitCallback, 指定请求失败要执行的回调方法
     * @return array
     */
    public function getUserInfo(int $id)
    {
        $user = User::query()->find($id);
        if (empty($user)) {
            throw new \RuntimeException("user not found");
        }
        return Result::success($user->toArray());
    }

    /**
     * 注意该方法必须是静态方法
     * @param float $seconds
     * @param ProceedingJoinPoint $proceedingJoinPoint
     */
    public static function limitCallback(float $seconds, ProceedingJoinPoint $proceedingJoinPoint)
    {
        //$result = $proceedingJoinPoint->process();
        throw new RateLimitException('请求过于频繁，请稍后再试！！！', 500);
    }

    /**
     * @return array
     */
    public function test()
    {
        $config = ApplicationContext::getContainer()->get(ConfigInterface::class);
        return Result::success([
            'info' => $config->get('hyperf_config'),
            'test' => $config->get('test'),
            'hyperf_env' => $config->get('hyperf_env'),
        ]);
    }

    /**
     * 获取nacos server注册的所有服务信息
     * @return array
     */
    public function discovery()
    {
        // 获取服务名
        $config = ApplicationContext::getContainer()->get(ConfigInterface::class);
        $groupName = $config->get('services.drivers.nacos.group_name');
        $namespaceId = $config->get('services.drivers.nacos.namespace_id');

        $client = ApplicationContext::getContainer()->get(Client::class);
        $services = Json::decode((string) $client->service->list(1, 10, $groupName, $namespaceId)->getBody());
        $details = [];
        if (!empty($services['doms'])) {
            $optional = [
                'groupName' => $groupName,
                'namespaceId' => $namespaceId,
            ];
            foreach ($services['doms'] as $service) {
                // 获取各个服务的信息
                $details[] = Json::decode((string) $client->instance->list($service, $optional)->getBody());
            }
        }

        return Result::success($details);
    }

    /**
     * 获取当前服务信息
     * @return array
     */
    public function getServerInfo()
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

        return Result::success([
            'appName' => $appName,
            'port' => $port,
        ]);
    }

    /**
     * @param $id
     * @return array
     */
    public function timeout($id)
    {
        try {
            // 暂停1秒模拟业务耗时
            if ($id > 0) {
                sleep(1);
            }
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }
        return Result::success([]);
    }

    /**
     * @Cacheable(prefix="userInfo", ttl="60")
     * @param int $id
     * @return array
     */
    public function getUserInfoFromCache(int $id)
    {
        $user = User::query()->find($id);
        if (empty($user)) {
            throw new \RuntimeException("user not found");
        }
        return Result::success($user->toArray());
    }
}




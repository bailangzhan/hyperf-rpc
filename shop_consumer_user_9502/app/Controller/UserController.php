<?php

declare(strict_types=1);
namespace App\Controller;

use App\Constants\ErrorCode;
use App\JsonRpc\UserServiceInterface;
use Hyperf\CircuitBreaker\Annotation\CircuitBreaker;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;
use Bailangzhan\Result\Result;

/**
 * Class UserController
 * @package App\Controller
 * @AutoController()
 */
class UserController extends AbstractController
{
    /**
     * @Inject()
     * @var UserServiceInterface
     */
    private $userServiceClient;

    public function createUser()
    {
        $name = (string) $this->request->input('name', '');
        $gender = (int) $this->request->input('gender', 0);
        $result = $this->userServiceClient->createUser($name, $gender);
        if ($result['code'] != ErrorCode::SUCCESS) {
            throw new \RuntimeException($result['message']);
        }
        return Result::success($result['data']);
    }

    public function getUserInfo()
    {
        $id = (int) $this->request->input('id');
        $result = $this->userServiceClient->getUserInfo($id);
        if ($result['code'] != ErrorCode::SUCCESS) {
            throw new \RuntimeException($result['message']);
        }
        return Result::success($result['data']);
    }

    public function test()
    {
        return Result::success($this->userServiceClient->test());
    }

    public function getServerInfo()
    {
        return Result::success($this->userServiceClient->getServerInfo());
    }

    /**
     * @CircuitBreaker(timeout=0.5, duration=10, failCounter=1, successCounter=3, fallback=Hyperf\CircuitBreaker\FallbackInterface::class)
     * CircuitBreaker 熔断器默认是超时熔断
     * timeout=0.5 超时时间大于0.5秒开启熔断器
     * duration=10 熔断后，重新恢复服务调用的时间，10秒内新的请求会执行 fallback 方法
     * failCounter=1 超时次数大于等于1，开启熔断器
     * successCounter=3 成功次数大于等于3，关闭熔断器
     * fallback 属性用于指定熔断时执行的方法
     * @return array
     */
    public function testCircuitBreaker()
    {
        $id = (int) $this->request->input('id');

        $result = $this->userServiceClient->timeout($id);
        if ($result['code'] != ErrorCode::SUCCESS) {
            throw new \RuntimeException($result['message']);
        }
        return Result::success($result['data']);
    }

    public function testCircuitBreakerFallback()
    {
        return Result::error("服务器繁忙！！！");
    }

    public function getUserInfoFromCache()
    {
        $id = (int) $this->request->input('id');
        $result = $this->userServiceClient->getUserInfoFromCache($id);
        if ($result['code'] != ErrorCode::SUCCESS) {
            throw new \RuntimeException($result['message']);
        }
        return Result::success($result['data']);
    }
}
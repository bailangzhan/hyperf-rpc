<?php

declare(strict_types=1);
namespace App\Controller;

use App\JsonRpc\UserServiceInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;

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
        return $this->userServiceClient->createUser($name, $gender);
    }

    public function getUserInfo()
    {
        $id = (int) $this->request->input('id');
        return $this->userServiceClient->getUserInfo($id);
    }
}
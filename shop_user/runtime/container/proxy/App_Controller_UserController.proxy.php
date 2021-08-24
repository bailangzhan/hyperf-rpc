<?php

declare (strict_types=1);
namespace App\Controller;

use App\Service\UserService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;
/**
 * Class UserController
 * @package App\Controller
 * @AutoController()
 */
class UserController
{
    use \Hyperf\Di\Aop\ProxyTrait;
    use \Hyperf\Di\Aop\PropertyHandlerTrait;
    function __construct()
    {
        $this->__handlePropertyHandler(__CLASS__);
    }
    /**
     * @Inject()
     * @var UserService
     */
    private $userService;
    /**
     * @return string
     */
    public function getInfo()
    {
        return $this->userService->getInfo();
    }
}
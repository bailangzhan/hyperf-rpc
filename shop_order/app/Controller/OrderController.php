<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\OrderService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;

/**
 * Class OrderController
 * @package App\Controller
 * @AutoController()
 */
class OrderController
{
    /**
     * @Inject()
     * @var OrderService
     */
    private $orderService;

    /**
     * @return string
     */
    public function getInfo()
    {
        return $this->orderService->getInfo();
    }
}

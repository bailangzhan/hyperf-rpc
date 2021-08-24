<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace Hyperf\HttpServer\Annotation;

use Hyperf\Di\Annotation\AbstractAnnotation;

abstract class Mapping extends AbstractAnnotation
{
    /**
     * @var array
     */
    public $methods;

    /**
     * @var string
     */
    public $path;

    /**
     * @var array
     */
    public $options = [];

    public function __construct(...$value)
    {
        parent::__construct(...$value);
        $this->bindMainProperty('path', $value);
    }
}

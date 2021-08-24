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
namespace Hyperf\Cache\Annotation;

use Attribute;
use Hyperf\Di\Annotation\AbstractAnnotation;

/**
 * @Annotation
 * @Target({"METHOD"})
 */
#[Attribute(Attribute::TARGET_METHOD)]
class CachePut extends AbstractAnnotation
{
    /**
     * @var string
     */
    public $prefix;

    /**
     * @var string
     */
    public $value;

    /**
     * @var null|int
     */
    public $ttl;

    /**
     * The max offset for ttl.
     * @var int
     */
    public $offset = 0;

    /**
     * @var string
     */
    public $group = 'default';

    public function __construct(...$value)
    {
        parent::__construct(...$value);
        if ($this->ttl !== null) {
            $this->ttl = (int) $this->ttl;
        }
        $this->offset = (int) $this->offset;
    }
}

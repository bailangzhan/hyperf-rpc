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
namespace Hyperf\Di\Annotation;

use Attribute;
use Hyperf\Di\Exception\AnnotationException;
use Hyperf\Di\ReflectionManager;
use Hyperf\Utils\CodeGen\PhpDocReaderManager;
use PhpDocReader\AnnotationException as DocReaderAnnotationException;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class Inject extends AbstractAnnotation
{
    /**
     * @var string
     */
    public $value;

    /**
     * @var bool
     */
    public $required = true;

    /**
     * @var bool
     */
    public $lazy = false;

    public function collectProperty(string $className, ?string $target): void
    {
        try {
            $reflectionClass = ReflectionManager::reflectClass($className);

            $reflectionProperty = $reflectionClass->getProperty($target);

            if (method_exists($reflectionProperty, 'hasType') && $reflectionProperty->hasType()) {
                /* @phpstan-ignore-next-line */
                $this->value = $reflectionProperty->getType()->getName();
            } else {
                $this->value = PhpDocReaderManager::getInstance()->getPropertyClass($reflectionProperty);
            }

            if (empty($this->value)) {
                throw new AnnotationException("The @Inject value is invalid for {$className}->{$target}");
            }

            if ($this->lazy) {
                $this->value = 'HyperfLazy\\' . $this->value;
            }
            AnnotationCollector::collectProperty($className, $target, static::class, $this);
        } catch (AnnotationException | DocReaderAnnotationException $exception) {
            if ($this->required) {
                throw new AnnotationException($exception->getMessage());
            }
            $this->value = '';
        } catch (\Throwable $exception) {
            throw new AnnotationException("The @Inject value is invalid for {$className}->{$target}. Because {$exception->getMessage()}");
        }
    }
}

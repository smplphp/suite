<?php
declare(strict_types=1);

namespace Smpl\Reflection\Predicates;

use Override;
use ReflectionAttribute;

/**
 *
 */
final class MethodHasAttributePredicate extends BaseMethodPredicate
{
    /**
     * @var class-string
     */
    private readonly string $attributeClass;

    /**
     * @var bool
     */
    private readonly bool $instanceOf;

    /**
     * @param class-string $attributeClass
     * @param bool         $instanceOf
     */
    public function __construct(string $attributeClass, bool $instanceOf = true)
    {
        $this->attributeClass = $attributeClass;
        $this->instanceOf     = $instanceOf;
    }

    /**
     * @param \ReflectionMethod $value
     *
     * @return bool
     */
    #[Override]
    public function test(mixed $value): bool
    {
        return ! empty($value->getAttributes(
            $this->attributeClass,
            $this->instanceOf ? ReflectionAttribute::IS_INSTANCEOF : 0)
        );
    }
}

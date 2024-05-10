<?php
declare(strict_types=1);

namespace Smpl\Reflection\Predicates;

use Override;

/**
 *
 */
final class ClassImplementsPredicate extends BaseClassPredicate
{
    /**
     * @var class-string
     */
    private string $interfaceClass;

    /**
     * @param class-string $interfaceClass
     */
    public function __construct(string $interfaceClass)
    {
        $this->interfaceClass = $interfaceClass;
    }

    /**
     * @param \ReflectionClass<object> $value
     *
     * @return bool
     */
    #[Override]
    public function test(mixed $value): bool
    {
        return $value->implementsInterface($this->interfaceClass);
    }
}

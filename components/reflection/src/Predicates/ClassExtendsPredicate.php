<?php
declare(strict_types=1);

namespace Smpl\Reflection\Predicates;

use Override;

/**
 *
 */
final class ClassExtendsPredicate extends BaseClassPredicate
{
    /**
     * @var class-string
     */
    private string $superClass;

    /**
     * @param class-string $superClass
     */
    public function __construct(string $superClass)
    {
        $this->superClass = $superClass;
    }

    /**
     * @param \ReflectionClass<object> $value
     *
     * @return bool
     */
    #[Override]
    public function test(mixed $value): bool
    {
        return $value->isSubclassOf($this->superClass);
    }
}

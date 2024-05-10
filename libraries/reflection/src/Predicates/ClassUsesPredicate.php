<?php
declare(strict_types=1);

namespace Smpl\Reflection\Predicates;

use Override;

/**
 *
 */
final class ClassUsesPredicate extends BaseClassPredicate
{
    /**
     * @var class-string
     */
    private string $traitClass;

    /**
     * @param class-string $traitClass
     */
    public function __construct(string $traitClass)
    {
        $this->traitClass = $traitClass;
    }

    /**
     * @param \ReflectionClass<object> $value
     *
     * @return bool
     */
    #[Override]
    public function test(mixed $value): bool
    {
        return in_array($this->traitClass, $value->getTraitNames());
    }
}

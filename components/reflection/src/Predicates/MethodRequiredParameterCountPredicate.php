<?php
declare(strict_types=1);

namespace Smpl\Reflection\Predicates;

use Override;

final class MethodRequiredParameterCountPredicate extends BaseMethodPredicate
{
    private int $count;

    public function __construct(int $count)
    {
        $this->count = $count;
    }

    /**
     * @param \ReflectionMethod $value
     *
     * @return bool
     */
    #[Override]
    public function test(mixed $value): bool
    {
        return $value->getNumberOfRequiredParameters() === $this->count;
    }
}

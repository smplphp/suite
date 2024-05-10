<?php
declare(strict_types=1);

namespace Smpl\Reflection\Predicates;

use Override;

final class MethodNameEndsWithPredicate extends BaseMethodPredicate
{
    private string $suffix;

    public function __construct(string $suffix)
    {
        $this->suffix = $suffix;
    }

    /**
     * @param \ReflectionMethod $value
     *
     * @return bool
     */
    #[Override]
    public function test(mixed $value): bool
    {
        return str_ends_with($value->getShortName(), $this->suffix);
    }
}

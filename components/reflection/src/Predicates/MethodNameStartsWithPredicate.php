<?php
declare(strict_types=1);

namespace Smpl\Reflection\Predicates;

use Override;

final class MethodNameStartsWithPredicate extends BaseMethodPredicate
{
    private string $prefix;

    public function __construct(string $prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * @param \ReflectionMethod $value
     *
     * @return bool
     */
    #[Override]
    public function test(mixed $value): bool
    {
        return str_starts_with($value->getShortName(), $this->prefix);
    }
}

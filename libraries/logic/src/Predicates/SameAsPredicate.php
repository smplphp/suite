<?php
declare(strict_types=1);

namespace Smpl\Logic\Predicates;

use Override;

/**
 * Same As Predicate
 *
 * Same as predicates check whether a value is the same as a target value.
 * This check is equivalent to checking that two values are identical.
 *
 * @template ValType of mixed
 *
 * @extends \Smpl\Logic\Predicates\BasePredicate<ValType>
 */
final class SameAsPredicate extends BasePredicate
{
    /**
     * The target to check against
     *
     * @var ValType
     */
    private mixed $target;

    /**
     * Create a new instance of the less than predicate
     *
     * @param ValType $target
     */
    public function __construct(mixed $target)
    {
        $this->target = $target;
    }

    /**
     * Test a value
     *
     * This method returns true if the provided value is the same as/identical
     * to the target.
     *
     * @param ValType $value
     *
     * @return bool
     */
    #[Override]
    public function test(mixed $value): bool
    {
        return $value === $this->target;
    }
}

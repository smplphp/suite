<?php
declare(strict_types=1);

namespace Smpl\Logic\Predicates;

use Override;

/**
 * Equal To Predicate
 *
 * Equal to predicates check that a value is functionally equal to a target
 * value.
 * This check is the same as using the equality operator (`==`) to compare
 * two values.
 *
 * @extends \Smpl\Logic\Predicates\BasePredicate<mixed>
 */
final class EqualToPredicate extends BasePredicate
{
    /**
     * The target to check against
     *
     * @var mixed
     */
    private mixed $target;

    /**
     * Create a new instance of the less than predicate
     *
     * @param mixed $target
     */
    public function __construct(mixed $target)
    {
        $this->target = $target;
    }

    /**
     * Test a value
     *
     * This method returns true if the provided value is considered
     * functionally equal to the target.
     *
     * @param mixed $value
     *
     * @return bool
     */
    #[Override]
    public function test(mixed $value): bool
    {
        /**
         * The equality operator is intentionally used here.
         *
         * @noinspection TypeUnsafeComparisonInspection
         */
        return $value == $this->target;
    }
}

<?php
declare(strict_types=1);

namespace Smpl\Logic\Predicates;

use Countable;
use Override;

/**
 * Numerically Equal To Predicate
 *
 * Equal to predicates check that a numeric value is functionally equal to a target
 * value.
 * This check is the same as using the equality operator (`==`) to compare
 * two values.
 *
 * @extends \Smpl\Logic\Predicates\BasePredicate<int|float|Countable>
 */
final class NumericallyEqualToPredicate extends BasePredicate
{
    /**
     * The target to check against
     *
     * @var int|float|Countable
     */
    private int|float|Countable $target;

    /**
     * Create a new instance of the less than predicate
     *
     * @param int|float|Countable $target
     */
    public function __construct(int|float|Countable $target)
    {
        $this->target = $target;
    }

    /**
     * Test a value
     *
     * This method returns true if the provided value is considered
     * functionally equal to the target.
     *
     * @param int|float|Countable $value
     *
     * @return bool
     */
    #[Override]
    public function test(mixed $value): bool
    {
        $target = $this->target;

        if ($target instanceof Countable) {
            $target = $target->count();
        }

        if ($value instanceof Countable) {
            $value = $value->count();
        }

        /** @psalm-suppress DocblockTypeContradiction */
        if (! is_numeric($value)) {
            return false;
        }

        /**
         * The equality operator is intentionally used here.
         *
         * @noinspection TypeUnsafeComparisonInspection
         */
        return $value == $target;
    }
}

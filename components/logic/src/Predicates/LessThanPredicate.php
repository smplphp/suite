<?php
declare(strict_types=1);

namespace Smpl\Logic\Predicates;

use Countable;
use Override;

/**
 * Less Than Predicate
 *
 * Less than predicates check whether an int, float or {@see \Countable}
 * is Less than a target int or float.
 *
 * @extends \Smpl\Logic\Predicates\BasePredicate<int|float|\Countable>
 */
final class LessThanPredicate extends BasePredicate
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
     * This method returns true if the provided value is less than the
     * target.
     *
     * @param int|float|\Countable $value
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

        // Since this is technically a 'mixed' value, it's possible a non-numeric
        // value could sneak through, so let's check for that.
        /** @psalm-suppress DocblockTypeContradiction */
        if (! is_numeric($value)) {
            return false;
        }

        return $value < $target;
    }
}

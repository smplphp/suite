<?php
declare(strict_types=1);

namespace Smpl\Logic\Predicates;

use Override;

/**
 * Logical AND Predicate
 *
 * A logical AND predicate takes multiple instances of {@see \Smpl\Logic\Contracts\Predicate}
 * and tests a single value against all of them, passing this predicate if all
 * pass.
 *
 * This class is called the logical AND predicate, but it does not use the
 * logical AND operator, it instead short-circuits and returns early if any
 * predicate fails.
 *
 * @template ValType of mixed
 *
 * @extends \Smpl\Logic\Predicates\BasePredicate<ValType>
 */
final class LogicalAndPredicate extends BasePredicate
{
    /**
     * @var \Smpl\Logic\Contracts\Predicate<ValType>[]
     */
    private array $predicates;

    /**
     * Create a new instance of the logical or predicate
     *
     * @param \Smpl\Logic\Contracts\Predicate<ValType>[] $predicates
     */
    public function __construct(array $predicates)
    {
        $this->predicates = $predicates;
    }

    /**
     * Test a value
     *
     * This method will return true if the value passes all predicates.
     *
     * This method short circuits if a single predicate returns false.
     *
     * @param ValType $value
     *
     * @return bool
     */
    #[Override]
    public function test(mixed $value): bool
    {
        foreach ($this->predicates as $predicate) {
            if (! $predicate->test($value)) {
                return false;
            }
        }

        return true;
    }
}

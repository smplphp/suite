<?php
declare(strict_types=1);

namespace Smpl\Logic\Predicates;

use Override;
use Smpl\Logic\Contracts\Predicate;

/**
 * Logical OR Predicate
 *
 * A logical OR predicate takes multiple instances of {@see \Smpl\Logic\Contracts\Predicate}
 * and tests the same value with all, looking for the first pass.
 *
 * This class is called the logical OR predicate, but it does not use the
 * logical OR operator.
 *
 * @template ValType of mixed
 *
 * @extends \Smpl\Logic\Predicates\BasePredicate<ValType>
 */
final class LogicalOrPredicate extends BasePredicate
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
     * This method will return true if the value passes one of the predicates.
     *
     * @param ValType $value
     *
     * @return bool
     */
    #[Override]
    public function test(mixed $value): bool
    {
        foreach ($this->predicates as $predicate) {
            if ($predicate->test($value)) {
                return true;
            }
        }

        return false;
    }
}

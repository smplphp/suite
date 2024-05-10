<?php
declare(strict_types=1);

namespace Smpl\Logic\Predicates;

use Override;
use Smpl\Logic\Contracts\Predicate;

/**
 * Logical XOR Predicate
 *
 * A logical XOR predicate takes two instances of {@see \Smpl\Logic\Contracts\Predicate}
 * and tests the same value with one, then the other, looking for a true
 * value from one, but not both.
 *
 * @template ValType of mixed
 *
 * @extends \Smpl\Logic\Predicates\BasePredicate<ValType>
 */
final class LogicalXorPredicate extends BasePredicate
{
    /**
     * @var \Smpl\Logic\Contracts\Predicate<ValType>
     */
    private Predicate $first;

    /**
     * @var \Smpl\Logic\Contracts\Predicate<ValType>
     */
    private Predicate $second;

    /**
     * Create a new instance of the logical xor predicate
     *
     * @param \Smpl\Logic\Contracts\Predicate<ValType> $first
     * @param \Smpl\Logic\Contracts\Predicate<ValType> $second
     */
    public function __construct(Predicate $first, Predicate $second)
    {
        $this->first  = $first;
        $this->second = $second;
    }

    /**
     * Test a value
     *
     * This method will return true if the value passes the first or second
     * predicate, but not both.
     *
     * @param ValType $value
     *
     * @return bool
     */
    #[Override]
    public function test(mixed $value): bool
    {
        return $this->first->test($value) xor $this->second->test($value);
    }
}

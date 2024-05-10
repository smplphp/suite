<?php
declare(strict_types=1);

namespace Smpl\Logic\Predicates;

use Override;
use Smpl\Logic\Contracts\Predicate;

/**
 * Negated Predicate
 *
 * Negated predicates negate the result of a {@see \Smpl\Logic\Contracts\Predicate},
 * essentially inverting the result of a predicate.
 *
 * @template ValType of mixed
 *
 * @extends \Smpl\Logic\Predicates\BasePredicate<ValType>
 */
final class NegatedPredicate extends BasePredicate
{
    /**
     * The predicate to negate
     *
     * @var \Smpl\Logic\Contracts\Predicate<ValType>
     */
    private Predicate $predicate;

    /**
     * Create a new instance of the negated predicate
     *
     * @param \Smpl\Logic\Contracts\Predicate<ValType> $predicate
     */
    public function __construct(Predicate $predicate)
    {
        $this->predicate = $predicate;
    }

    /**
     * Test a value
     *
     * This method will return true if the predicate this class is wrapping
     * fails, and false if it passes.
     *
     * @param ValType $value
     *
     * @return bool
     */
    #[Override]
    public function test(mixed $value): bool
    {
        return ! $this->predicate->test($value);
    }
}

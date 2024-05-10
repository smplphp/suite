<?php
declare(strict_types=1);

namespace Smpl\Logic\Predicates;

use Override;
use Smpl\Logic\Contracts\Operation;
use Smpl\Logic\Contracts\Predicate;

/**
 * Composed Predicate
 *
 * Composed predicates test the return value of an {@see \Smpl\Logic\Contracts\Operation}.
 *
 * The composed predicate is a sibling of {@see \Smpl\Logic\Operations\ComposedOperation},
 * except that the after operation is an instance of the
 * {@see \Smpl\Logic\Contracts\Predicate} contract.
 *
 * @package Logic\Predicates
 *
 * @template ArgType of mixed
 * @template MidType of mixed
 *
 * @extends \Smpl\Logic\Predicates\BasePredicate<ArgType>
 */
final class ComposedPredicate extends BasePredicate
{
    /**
     * The before operation
     *
     * @var \Smpl\Logic\Contracts\Operation<ArgType, MidType>
     */
    private Operation $before;

    /**
     * The after predicate
     *
     * @var \Smpl\Logic\Contracts\Predicate<MidType>
     */
    private Operation $after;

    /**
     * Create a new instance of the composed predicate
     *
     * @param \Smpl\Logic\Contracts\Operation<ArgType, MidType> $before
     * @param \Smpl\Logic\Contracts\Predicate<MidType>          $after
     */
    public function __construct(Operation $before, Predicate $after)
    {
        $this->before = $before;
        $this->after  = $after;
    }

    /**
     * Test a value
     *
     * This method calls the before operation with the provided argument, and then
     * tests its return value with the after predicate.
     *
     * @param ArgType $value
     *
     * @return bool
     */
    #[Override]
    public function test(mixed $value): bool
    {
        return $this->after->test($this->before->perform($value));
    }
}

<?php

namespace Smpl\Logic\Contracts;

/**
 * Predicate
 *
 * Predicates are boolean-value functions.
 * They "test" a single value against implementation-specific logic to determine
 * whether it passes (returns true), or fails (returns false).
 *
 * A predicate is also an {@see \Smpl\Logic\Contracts\Operation}, with the only
 * difference being that it has a hard-coded return type.
 *
 * @package Logic\Predicates
 *
 * @template ValType of mixed
 *
 * @extends \Smpl\Logic\Contracts\Operation<ValType, bool>
 */
interface Predicate extends Operation
{
    /**
     * Test a value
     *
     * This method should return true if the value passes, and false otherwise.
     *
     * This method should have no side effects, and although it is recommended
     * that implementations simply fail if the value doesn't meet certain
     * criteria, some implementations may throw exceptions.
     *
     * @param ValType $value
     *
     * @return bool
     */
    public function test(mixed $value): bool;
}

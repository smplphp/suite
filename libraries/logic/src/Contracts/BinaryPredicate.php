<?php

namespace Smpl\Logic\Contracts;

/**
 * Binary Predicate
 *
 * Binary Predicates are boolean-value functions.
 * They "test" two values against implementation-specific logic to determine
 * whether it passes (returns true), or fails (returns false).
 *
 * A binary predicate is also a {@see \Smpl\Logic\Contracts\BinaryOperation},
 * with the only difference being that it has a hard-coded return type.
 *
 * @package Logic\Predicates
 *
 * @template ValType1 of mixed
 * @template ValType2 of mixed
 *
 * @extends \Smpl\Logic\Contracts\BinaryOperation<ValType1, ValType2, bool>
 */
interface BinaryPredicate extends Operation
{
    /**
     * Test the values
     *
     * This method should return true if the values pass, and false otherwise.
     *
     * This method should have no side effects, and although it is recommended
     * that implementations simply fail if the value doesn't meet certain
     * criteria, some implementations may throw exceptions.
     *
     * @param ValType1 $value1
     * @param ValType2 $value2
     *
     * @return bool
     */
    public function test(mixed $value1, mixed $value2): bool;
}

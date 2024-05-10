<?php

namespace Smpl\Logic\Contracts;

/**
 * Comparator
 *
 * Comparators compare two values to determine whether one is less than, greater
 * than, or equal to the other.
 * Comparators have a number of uses, but the most common is to order, or sort,
 * a collection of values.
 *
 * Comparators can be considered to be object-based implementations of the
 * mathematical sign function.
 *
 * @see https://en.wikipedia.org/wiki/Sign_function
 *
 * @package Logic\Comparators
 *
 * @template ValType of mixed
 *
 * @extends \Smpl\Logic\Contracts\BinaryOperation<ValType, ValType, int>
 */
interface Comparator extends BinaryOperation
{
    /**
     * Compare value a against value b
     *
     * This method returns a negative number if a is than b, a positive number
     * if a is greater than b, and a 0 if they are equal.
     * This method can be considered an implementation of the mathematical
     * sign function.
     *
     * It is recommended that this method returns a value within the range of
     * [-1, 1], though it is not required.
     *
     * Implementations of this method should ensure consistency such that if
     * the arguments were reversed, the expected inverse value would be returned.
     * IE, if a is less than b, -1, then b would be greater than a, 1.
     *
     * @param ValType $a
     * @param ValType $b
     *
     * @return int
     */
    public function compare(mixed $a, mixed $b): int;
}

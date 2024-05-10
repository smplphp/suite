<?php
declare(strict_types=1);

namespace Smpl\Logic\Comparators;

use Override;
use Smpl\Logic\Comparators;
use Smpl\Logic\Contracts\Comparator;
use Smpl\Logic\Operations\BaseBinaryOperation;

/**
 * Base Comparator
 *
 * A default base implementation of the {@see \Smpl\Logic\Contracts\Comparator}
 * contract that provides a basic implementation and features.
 *
 * @package Logic\Comparators
 *
 * @template ValType of mixed
 *
 * @extends \Smpl\Logic\Operations\BaseBinaryOperation<ValType, ValType, int>
 * @implements \Smpl\Logic\Contracts\Comparator<ValType>
 */
abstract class BaseComparator extends BaseBinaryOperation implements Comparator
{
    /**
     * Perform as an operation
     *
     * This method proxies calls to {@see self::compare()} so that this predicate
     * can act as an {@see \Smpl\Logic\Contracts\BinaryOperation} if necessary.
     *
     * @param ValType $arg1
     * @param ValType $arg2
     *
     * @return int
     */
    #[Override]
    public function perform(mixed $arg1, mixed $arg2): int
    {
        return $this->compare($arg1, $arg2);
    }

    /**
     * Create an inverted comparator from this comparator
     *
     * This method creates a comparator that reverses the argument order and
     * then calls this comparator.
     *
     * @return \Smpl\Logic\Contracts\Comparator<ValType>
     */
    public function invert(): Comparator
    {
        return Comparators::invert($this);
    }
}

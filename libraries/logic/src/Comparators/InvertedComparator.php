<?php
declare(strict_types=1);

namespace Smpl\Logic\Comparators;

use Override;
use Smpl\Logic\Contracts\Comparator;

/**
 * Inverted Comparator
 *
 * Inverted comparators wrap a second comparator, which it proxies all method
 * calls too, except that it reverses the order of the arguments, such that
 * b is compared to a, rather than a compared to b.
 *
 * @package Logic\Comparators
 *
 * @template ValType of mixed
 *
 * @extends \Smpl\Logic\Comparators\BaseComparator<ValType>
 */
final class InvertedComparator extends BaseComparator
{
    /**
     * @var \Smpl\Logic\Contracts\Comparator<ValType>
     */
    private Comparator $comparator;

    /**
     * @param \Smpl\Logic\Contracts\Comparator<ValType> $comparator
     */
    public function __construct(Comparator $comparator)
    {
        $this->comparator = $comparator;
    }

    /**
     * Compare value b against value a
     *
     * This method proxies the method call to the
     * {@see \Smpl\Logic\Contracts\Comparator} stored in {@see self::$comparator},
     * but reversing the argument order.
     *
     * @param ValType $a
     * @param ValType $b
     *
     * @return int
     */
    #[Override]
    public function compare(mixed $a, mixed $b): int
    {
        return $this->comparator->compare($b, $a);
    }

    /**
     * Create an inverted comparator from this comparator
     *
     * This method creates a comparator that reverses the argument order and
     * then calls this comparator.
     *
     * Since this comparator is already an inverted comparator, the inverted
     * version of it would be the comparator stored in {@see self::$comparator}.
     *
     * @return \Smpl\Logic\Contracts\Comparator<ValType>
     */
    public function invert(): Comparator
    {
        return $this->comparator;
    }
}

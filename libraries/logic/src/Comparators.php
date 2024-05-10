<?php
declare(strict_types=1);

namespace Smpl\Logic;

use Smpl\Logic\Comparators\BasicComparator;
use Smpl\Logic\Comparators\InvertedComparator;
use Smpl\Logic\Contracts\Comparator;

final class Comparators
{
    /**
     * Create a basic comparator
     *
     * Basic comparators compare values using PHPs default spaceship operator.
     *
     * @link https://www.php.net/manual/en/language.operators.comparison.php
     *
     * @return \Smpl\Logic\Contracts\Comparator<mixed>
     */
    public static function basic(): Comparator
    {
        return new BasicComparator();
    }

    /**
     * Create an inverted comparator
     *
     * Inverted comparators wrap other comparators and reverse the order of the
     * arguments, checking b against a, rather than a against b.
     *
     * @template ValType of mixed
     *
     * @param \Smpl\Logic\Contracts\Comparator<ValType> $comparator
     *
     * @return \Smpl\Logic\Contracts\Comparator<ValType>
     */
    public static function invert(Comparator $comparator): Comparator
    {
        return new InvertedComparator($comparator);
    }
}

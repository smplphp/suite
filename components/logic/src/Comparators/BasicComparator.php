<?php
declare(strict_types=1);

namespace Smpl\Logic\Comparators;

use Override;

/**
 * Basic Comparator
 *
 * The basic comparator uses PHPs default comparison operation, the spaceship
 * operation (`<=>`) to perform comparison.
 * This operation has its own set of rules and nuances, so it is recommended that
 * you familiarise yourself with it.
 *
 * @link https://www.php.net/manual/en/language.operators.comparison.php
 *
 * @package Logic\Comparators
 *
 * @extends \Smpl\Logic\Comparators\BaseComparator<mixed>
 */
final class BasicComparator extends BaseComparator
{
    /**
     * Compare value a against value b
     *
     * This method returns a negative number if a is than b, a positive number
     * if a is greater than b, and a 0 if they are equal.
     * This method can be considered an implementation of the mathematical
     * sign function.
     *
     * This method uses the PHP spaceship operation (`<=>`), which has its own
     * set of rules and nuances.
     *
     * @link https://www.php.net/manual/en/language.operators.comparison.php
     *
     * @param mixed $a
     * @param mixed $b
     *
     * @return int
     */
    #[Override]
    public function compare(mixed $a, mixed $b): int
    {
        return $a <=> $b;
    }
}

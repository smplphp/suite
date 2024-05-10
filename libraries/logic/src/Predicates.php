<?php
declare(strict_types=1);

namespace Smpl\Logic;

use Countable;
use Smpl\Logic\Contracts\Operation;
use Smpl\Logic\Contracts\Predicate;
use Smpl\Logic\Predicates\ComposedPredicate;
use Smpl\Logic\Predicates\EqualToPredicate;
use Smpl\Logic\Predicates\GreaterThanPredicate;
use Smpl\Logic\Predicates\LessThanPredicate;
use Smpl\Logic\Predicates\LogicalAndPredicate;
use Smpl\Logic\Predicates\LogicalOrPredicate;
use Smpl\Logic\Predicates\LogicalXorPredicate;
use Smpl\Logic\Predicates\NegatedPredicate;
use Smpl\Logic\Predicates\NumericallyEqualToPredicate;
use Smpl\Logic\Predicates\ProxyPredicate;
use Smpl\Logic\Predicates\SameAsPredicate;

/**
 * Predicates
 *
 * Helper class for utilising the default implementations of predicates.
 *
 * @package Logic\Predicates
 *
 * @infection-ignore-all
 */
final class Predicates
{
    /**
     * Create a composed predicate of an operation and a predicate
     *
     * Composed predicates are predicates that test the return value of a
     * provided operation.
     *
     * @param \Smpl\Logic\Contracts\Operation<ArgType, MidType> $before
     * @param \Smpl\Logic\Contracts\Predicate<MidType>          $after
     *
     * @return \Smpl\Logic\Contracts\Predicate<ArgType>
     *
     * @see \Smpl\Logic\Predicates\ComposedPredicate
     *
     * @template ArgType of mixed
     * @template MidType of mixed
     */
    public static function compose(Operation $before, Predicate $after): Predicate
    {
        return new ComposedPredicate($before, $after);
    }

    /**
     * Wrap the provided callable in a predicate
     *
     * This method wraps the provided callable in an implementation of
     * {@see \Smpl\Logic\Contracts\Predicate}.
     * No checks are performed on the callable signature, so type errors
     * may occur.
     *
     * @template ValType of mixed
     *
     * @param callable(ValType $value): bool $callable
     *
     * @return \Smpl\Logic\Contracts\Predicate<ValType>
     */
    public static function wrap(callable $callable): Predicate
    {
        // If the callable is already a predicate, we'll short-circuit and return
        // that, to avoid just infinitely nesting predicates.
        if ($callable instanceof Predicate) {
            return $callable;
        }

        return new ProxyPredicate($callable);
    }

    /**
     * Create a logical AND predicate
     *
     * Logical AND predicates test a value against a multiple child-predicates,
     * with the value only passing if it passes all child-predicates.
     *
     * @template ValType of mixed
     *
     * @param \Smpl\Logic\Contracts\Predicate<ValType> ...$predicates
     *
     * @return \Smpl\Logic\Contracts\Predicate<ValType>
     */
    public static function and(Predicate ...$predicates): Predicate
    {
        return new LogicalAndPredicate($predicates);
    }

    /**
     * Create a logical OR predicate
     *
     * Logical OR predicates test a value against a two child-predicates,
     * with the value only passing if it passes one or both child-predicates.
     *
     * @template ValType of mixed
     *
     * @param \Smpl\Logic\Contracts\Predicate<ValType> ...$predicates
     *
     * @return \Smpl\Logic\Contracts\Predicate<ValType>
     */
    public static function or(Predicate ...$predicates): Predicate
    {
        return new LogicalOrPredicate($predicates);
    }

    /**
     * Create a logical XOR predicate
     *
     * Logical XOR predicates test a value against a two child-predicates,
     * with the value only passing if it passes one child-predicate, but not
     * both.
     *
     * @template ValType of mixed
     *
     * @param \Smpl\Logic\Contracts\Predicate<ValType> $first
     * @param \Smpl\Logic\Contracts\Predicate<ValType> $second
     *
     * @return \Smpl\Logic\Contracts\Predicate<ValType>
     */
    public static function xor(Predicate $first, Predicate $second): Predicate
    {
        return new LogicalXorPredicate($first, $second);
    }

    /**
     * Create a negated predicate
     *
     * Negated predicates wrap other predicates and invert their result,
     * making passes fail and fails pass.
     *
     * @template ValType of mixed
     *
     * @param \Smpl\Logic\Contracts\Predicate<ValType> $predicate
     *
     * @return \Smpl\Logic\Contracts\Predicate<ValType>
     */
    public static function negate(Predicate $predicate): Predicate
    {
        return new NegatedPredicate($predicate);
    }

    /**
     * Create a less than predicate
     *
     * Less than predicates test a value to see if it is less than a provided
     * target value.
     *
     * Unlike most predicates, the numerical comparison predicates will test any
     * value that is an integer, float or an instance of {@see \Countable}.
     *
     * @param int|float|\Countable $target
     *
     * @return \Smpl\Logic\Contracts\Predicate<int|float|\Countable>
     */
    public static function lessThan(int|float|Countable $target): Predicate
    {
        return new LessThanPredicate($target);
    }

    /**
     * Create a less than or equal to predicate
     *
     * Less than or equal to predicates test that a value is less than a provided
     * target value, or equal to it.
     *
     * Unlike most predicates, the numerical comparison predicates will test any
     * value that is an integer, float or an instance of {@see \Countable}.     *
     *
     * @param int|float|\Countable $target
     *
     * @return \Smpl\Logic\Contracts\Predicate<int|float|\Countable>
     */
    public static function lessThanOrEqualTo(int|float|Countable $target): Predicate
    {
        return self::or(
            self::lessThan($target),
            self::numericallyEqualTo($target)
        );
    }

    /**
     * Create a greater than predicate
     *
     * Greater than predicates test a value to see if it is greater than a provided
     * target value.
     *
     * Unlike most predicates, the numerical comparison predicates will test any
     * value that is an integer, float or an instance of {@see \Countable}.
     *
     * @param int|float|\Countable $target
     *
     * @return \Smpl\Logic\Contracts\Predicate<int|float|\Countable>
     */
    public static function greaterThan(int|float|Countable $target): Predicate
    {
        return new GreaterThanPredicate($target);
    }

    /**
     * Create a greater than or equal to predicate
     *
     * Greater than or equal to predicates test that a value is greater than a
     * provided target value, or equal to it.
     *
     * Unlike most predicates, the numerical comparison predicates will test any
     * value that is an integer, float or an instance of {@see \Countable}.
     *
     * @param int|float|\Countable $target
     *
     * @return \Smpl\Logic\Contracts\Predicate<int|float|\Countable>
     */
    public static function greaterThanOrEqualTo(int|float|Countable $target): Predicate
    {
        return self::or(
            self::greaterThan($target),
            self::numericallyEqualTo($target)
        );
    }

    /**
     * Create a between predicate
     *
     * Between predicates test that a value is between two provided values.
     *
     * Unlike most predicates, the numerical comparison predicates will test any
     * value that is an integer, float or an instance of {@see \Countable}.
     *
     * @param int|float|\Countable $low
     * @param int|float|\Countable $high
     *
     * @return \Smpl\Logic\Contracts\Predicate<int|float|\Countable>
     */
    public static function between(int|float|Countable $low, int|float|Countable $high): Predicate
    {
        return self::inRange($low, $high, false);
    }

    /**
     * Create an in rage predicate
     *
     * In rage predicates test that a value is within the range of two provided
     * values, with optional inclusivity at both the low and high ends.
     *
     * Unlike most predicates, the numerical comparison predicates will test any
     * value that is an integer, float or an instance of {@see \Countable}.
     *
     * @param int|float|\Countable $low
     * @param int|float|\Countable $high
     * @param bool                 $lowInclusive
     * @param bool                 $highInclusive
     *
     * @return \Smpl\Logic\Contracts\Predicate<int|float|\Countable>
     */
    public static function inRange(int|float|Countable $low, int|float|Countable $high, bool $lowInclusive = true, bool $highInclusive = false): Predicate
    {
        return self::and(
            $lowInclusive ? self::greaterThanOrEqualTo($low) : self::greaterThan($low),
            $highInclusive ? self::lessThanOrEqualTo($high) : self::lessThan($high)
        );
    }

    /**
     * Create an equal to predicate
     *
     * Equal to predicates test a value to see if it is functionally equal to a
     * provided target value.
     *
     * This predicate does not test that two values are identical; it uses the
     * equality operator (`==`).
     * If you need to test that two values are identical, use {@see self::sameAs()}.
     *
     * @template ValType of mixed
     *
     * @param ValType $target
     *
     * @return \Smpl\Logic\Contracts\Predicate<ValType>
     */
    public static function equalTo(mixed $target): Predicate
    {
        return new EqualToPredicate($target);
    }

    /**
     * Create an equal to predicate for numeric values
     *
     * Numerically equal to predicates test a numeric value to see if it is
     * functionally equal to a provided target value.
     *
     * This predicate does not test that two values are identical; it uses the
     * equality operator (`==`).
     * If you need to test that two values are identical, use {@see self::sameAs()}.
     *
     * @param int|float|\Countable $target
     *
     * @return \Smpl\Logic\Contracts\Predicate<int|float|\Countable>
     */
    public static function numericallyEqualTo(int|float|Countable $target): Predicate
    {
        return new NumericallyEqualToPredicate($target);
    }

    /**
     * Create a same as predicate
     *
     * Same as predicates test a value to see if it is identical to a provided
     * target value.
     *
     * This predicate uses the identical operator (`===`), if you need to test
     * that values are considered equal, use {@see self::equalTo()}.
     *
     * @template ValType of mixed
     *
     * @param ValType $target
     *
     * @return \Smpl\Logic\Contracts\Predicate<ValType>
     */
    public static function sameAs(mixed $target): Predicate
    {
        return new SameAsPredicate($target);
    }
}

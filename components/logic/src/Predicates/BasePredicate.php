<?php
declare(strict_types=1);

namespace Smpl\Logic\Predicates;

use LogicException;
use Override;
use Smpl\Logic\Contracts\Operation;
use Smpl\Logic\Contracts\Predicate;
use Smpl\Logic\Operations\BaseOperation;
use Smpl\Logic\Predicates;

/**
 * Base Predicate
 *
 * A default base implementation of the {@see \Smpl\Logic\Contracts\Predicate}
 * contract that provides a basic implementation and features.
 *
 * @package Logic\Predicates
 *
 * @template ValType of mixed
 *
 * @implements \Smpl\Logic\Contracts\Predicate<ValType>
 * @extends \Smpl\Logic\Operations\BaseOperation<ValType, bool>
 */
abstract class BasePredicate extends BaseOperation implements Predicate
{
    /**
     * Perform as an operation
     *
     * This method proxies calls to {@see self::test()} so that this predicate
     * can act as an {@see \Smpl\Logic\Contracts\Operation} if necessary.
     *
     * @param ValType $arg
     *
     * @return bool
     */
    #[Override]
    public function perform(mixed $arg): bool
    {
        return $this->test($arg);
    }

    /**
     * Compose this predicate with a before operation
     *
     * This method creates and returns a composed operation which calls the
     * provided before operation, and tests its return value with this predicate.
     *
     * @template BArgType of mixed
     *
     * @param \Smpl\Logic\Contracts\Operation<BArgType, ValType> $before
     *
     * @return \Smpl\Logic\Contracts\Predicate<BArgType>
     */
    public function after(Operation $before): Predicate
    {
        return Predicates::compose($before, $this);
    }

    /**
     * Compose this operation with an after operation
     *
     * Predicates cannot be composed as a before operation, so this method
     * should never be called.
     *
     * @template ARetType of mixed
     *
     * @param \Smpl\Logic\Contracts\Operation<bool, ARetType> $after
     *
     * @return never
     *
     * @throws \LogicException
     */
    public function before(Operation $after): never
    {
        throw new LogicException('Predicates cannot be composed as a before operation');
    }

    /**
     * Create a predicate of this and others, with a logical AND on the results
     *
     * This method creates a predicate that checks if a value passes this predicate
     * and all others provided.
     *
     * @param \Smpl\Logic\Contracts\Predicate<ValType> ...$predicates
     *
     * @return \Smpl\Logic\Contracts\Predicate<ValType>
     */
    public function and(Predicate ...$predicates): Predicate
    {
        return Predicates::and($this, ...$predicates);
    }

    /**
     * Create a predicate of this and others, with a logical OR on the results
     *
     * This method creates a predicate that checks if a value passes this
     * predicate and all others provided.
     *
     * @param \Smpl\Logic\Contracts\Predicate<ValType> ...$predicates
     *
     * @return \Smpl\Logic\Contracts\Predicate<ValType>
     */
    public function or(Predicate ...$predicates): Predicate
    {
        return Predicates::or($this, ...$predicates);
    }

    /**
     * Create a predicate of this and another, with a logical XOR on the results
     *
     * This method creates a predicate that checks if a value passes this
     * predicate, or a second, but not both.
     *
     * @param \Smpl\Logic\Contracts\Predicate<ValType> $second
     *
     * @return \Smpl\Logic\Contracts\Predicate<ValType>
     */
    public function xor(Predicate $second): Predicate
    {
        return Predicates::xor($this, $second);
    }

    /**
     * Create a negated predicate from this predicate
     *
     * This method creates a predicate that negates the result of this predicate
     * using a logical NOT operation.
     *
     * @return \Smpl\Logic\Contracts\Predicate<ValType>
     */
    public function negate(): Predicate
    {
        return Predicates::negate($this);
    }
}

<?php
declare(strict_types=1);

namespace Smpl\Logic;

use Smpl\Logic\Contracts\Operation;
use Smpl\Logic\Operations\ProxyOperation;
use Smpl\Logic\Operations\ComposedOperation;

/**
 * Operations Helper
 *
 * Helper class for utilising the default implementations of operations.
 *
 * @package Logic\Operations
 *
 * @infection-ignore-all
 */
final class Operations
{
    /**
     * Create a composed operation from two operations
     *
     * Composed operations are operations that perform the after operation
     * on the return value of the before operation.
     *
     * @see \Smpl\Logic\Operations\ComposedOperation
     *
     * @template ArgType of mixed
     * @template MidType of mixed
     * @template RetType of mixed
     *
     * @param \Smpl\Logic\Contracts\Operation<ArgType, MidType> $before
     * @param \Smpl\Logic\Contracts\Operation<MidType, RetType> $after
     *
     * @return \Smpl\Logic\Contracts\Operation<ArgType, RetType>
     */
    public static function compose(Operation $before, Operation $after): Operation
    {
        return new ComposedOperation($before, $after);
    }

    /**
     * Wrap the provided callable in an operation
     *
     * This method wraps the provided callable in an implementation of
     * {@see \Smpl\Logic\Contracts\Operation}.
     * No checks are performed on the callable signature, so type errors
     * may occur.
     *
     * @template ArgType of mixed
     * @template RetType of mixed
     *
     * @param callable(ArgType $arg): RetType $callable
     *
     * @return \Smpl\Logic\Contracts\Operation<ArgType, RetType>
     */
    public static function wrap(callable $callable): Operation
    {
        // If the callable is already an operation, we'll short-circuit and return
        // that, to avoid just infinitely nesting operations.
        if ($callable instanceof Operation) {
            return $callable;
        }

        return new ProxyOperation($callable);
    }
}

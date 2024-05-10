<?php
declare(strict_types=1);

namespace Smpl\Logic\Operations;

use Smpl\Logic\Contracts\Operation;
use Smpl\Logic\Operations;

/**
 * Base Operation
 *
 * A default base implementation of the {@see \Smpl\Logic\Contracts\Operation}
 * contract that provides a basic implementation and features.
 *
 * @package Logic\Operations
 *
 * @template ArgType of mixed
 * @template RetType of mixed
 *
 * @implements \Smpl\Logic\Contracts\Operation<ArgType, RetType>
 */
abstract class BaseOperation implements Operation
{
    /**
     * Magic invokable method
     *
     * This is a default implementation of the magic invoke method which
     * proxies to the {@see self::perform()} method.
     *
     * @param ArgType $arg
     *
     * @return RetType
     */
    public function __invoke(mixed $arg): mixed
    {
        return $this->perform($arg);
    }

    /**
     * Compose this operation with a before operation
     *
     * This method creates and returns a composed operation which calls the
     * provided before operation, and uses its return value to call this
     * operation, known as the after operation.
     *
     * @template BArgType of mixed
     *
     * @param \Smpl\Logic\Contracts\Operation<BArgType, ArgType> $before
     *
     * @return \Smpl\Logic\Contracts\Operation<BArgType, RetType>
     */
    public function after(Operation $before): Operation
    {
        return Operations::compose($before, $this);
    }

    /**
     * Compose this operation with an after operation
     *
     * This method creates and returns a composed operation which calls this
     * operation, known as the before operation, and uses the return value to
     * call the provided after operation.
     *
     * @template ARetType of mixed
     *
     * @param \Smpl\Logic\Contracts\Operation<RetType, ARetType> $after
     *
     * @return \Smpl\Logic\Contracts\Operation<ArgType, ARetType>
     */
    public function before(Operation $after): Operation
    {
        return Operations::compose($this, $after);
    }
}

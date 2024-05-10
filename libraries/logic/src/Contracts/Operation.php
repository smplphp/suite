<?php

namespace Smpl\Logic\Contracts;

/**
 * Operation
 *
 * Operations are object-based functions that take a single argument and return
 * a value.
 * Since operations are basically functions, no guarantees can be made about
 * particular implementations in matters such as side effects or immutability.
 *
 * @package Logic\Operations
 *
 * @template ArgType of mixed
 * @template RetType of mixed
 */
interface Operation
{
    /**
     * Perform the operation
     *
     * @param ArgType $arg
     *
     * @return RetType
     */
    public function perform(mixed $arg): mixed;

    /**
     * Magic invokable method
     *
     * This method makes instances of this class invokable, so they can be
     * used as a function/{@see \Closure}.
     *
     * @param ArgType $arg
     *
     * @return RetType
     */
    public function __invoke(mixed $arg): mixed;
}

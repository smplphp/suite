<?php

namespace Smpl\Logic\Contracts;

/**
 * Binary Operation
 *
 * Binary operations are object-based functions that take two arguments,
 * and return a value.
 * Since operations are basically functions, no guarantees can be made about
 * particular implementations in matters such as side effects or immutability.
 *
 * @package Logic\Operations
 *
 * @template Arg1Type of mixed
 * @template Arg2Type of mixed
 * @template RetType of mixed
 */
interface BinaryOperation
{
    /**
     * Perform the operation
     *
     * @param Arg1Type $arg1
     * @param Arg2Type $arg2
     *
     * @return RetType
     */
    public function perform(mixed $arg1, mixed $arg2): mixed;

    /**
     * Magic invokable method
     *
     * This method makes instances of this class invokable, so they can be
     * used as a function/{@see \Closure}.
     *
     * @param Arg1Type $arg1
     * @param Arg2Type $arg2
     *
     * @return RetType
     */
    public function __invoke(mixed $arg1, mixed $arg2): mixed;
}

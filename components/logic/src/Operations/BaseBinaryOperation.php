<?php
declare(strict_types=1);

namespace Smpl\Logic\Operations;

use Smpl\Logic\Contracts\BinaryOperation;

/**
 * Base Binary Operation
 *
 * A default base implementation of the {@see \Smpl\Logic\Contracts\BinaryOperation}
 * contract that provides a basic implementation and features.
 *
 * @package Logic\Operations
 *
 * @template Arg1Type of mixed
 * @template Arg2Type of mixed
 * @template RetType of mixed
 *
 * @implements \Smpl\Logic\Contracts\BinaryOperation<Arg1Type, Arg2Type, RetType>
 */
abstract class BaseBinaryOperation implements BinaryOperation
{
    /**
     * Magic invokable method
     *
     * This is a default implementation of the magic invoke method which
     * proxies to the {@see self::perform()} method.
     *
     * @param Arg1Type $arg1
     * @param Arg2Type $arg2
     *
     * @return RetType
     */
    public function __invoke(mixed $arg1, mixed $arg2): mixed
    {
        return $this->perform($arg1, $arg2);
    }
}

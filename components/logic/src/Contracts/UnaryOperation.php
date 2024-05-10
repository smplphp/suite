<?php

namespace Smpl\Logic\Contracts;

/**
 * Unary Operation
 *
 * Unary operations are a specific type of {@see \Smpl\Logic\Contracts\Operation}
 * that returns a value of the same type that it receives.
 *
 * @package Logic\Operations
 *
 * @template ValType of mixed
 *
 * @extends \Smpl\Logic\Contracts\Operation<ValType, ValType>
 */
interface UnaryOperation extends Operation
{

}

<?php
declare(strict_types=1);

namespace Smpl\Logic\Operations;

/**
 * Base Unary Operation
 *
 * A default base implementation of the {@see \Smpl\Logic\Contracts\UnaryOperation}
 * contract that provides a basic implementation and features.
 *
 * @package Logic\Operations
 *
 * @template ValType of mixed
 *
 * @extends \Smpl\Logic\Operations\BaseOperation<ValType, ValType>
 */
abstract class BaseUnaryOperation extends BaseOperation
{

}

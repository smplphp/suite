<?php
declare(strict_types=1);

namespace Smpl\Logic\Operations;

use Override;
use Smpl\Logic\Contracts\Operation;

/**
 * Composed Operation
 *
 * Composed operations are operations that contain a before and after operation.
 *
 * When calling a composed operation, its single argument is passed to the before
 * operation, whose return value is used as the argument for the after operation,
 * whose return value is returned to the caller.
 *
 * This class can be considered a PHP implementation function composition.
 *
 * @see https://en.wikipedia.org/wiki/Function_composition
 *
 * @package Logic\Operations
 *
 * @template ArgType of mixed
 * @template MidType of mixed
 * @template RetType of mixed
 *
 * @extends \Smpl\Logic\Operations\BaseOperation<ArgType, RetType>
 */
final class ComposedOperation extends BaseOperation
{
    /**
     * The before operation
     *
     * @var \Smpl\Logic\Contracts\Operation<ArgType, MidType>
     */
    private Operation $before;

    /**
     * The after operation
     *
     * @var \Smpl\Logic\Contracts\Operation<MidType, RetType>
     */
    private Operation $after;

    /**
     * Create a new instance of the composed operation
     *
     * @param \Smpl\Logic\Contracts\Operation<ArgType, MidType> $before
     * @param \Smpl\Logic\Contracts\Operation<MidType, RetType> $after
     */
    public function __construct(Operation $before, Operation $after)
    {
        $this->before = $before;
        $this->after  = $after;
    }

    /**
     * Perform the operation
     *
     * This method calls the before operation with the provided argument, and then
     * uses its return value to call the after operation to then finally return
     * that operations' return value.
     *
     * @param ArgType $arg
     *
     * @return RetType
     */
    #[Override]
    public function perform(mixed $arg): mixed
    {
        return $this->after->perform($this->before->perform($arg));
    }
}

<?php
declare(strict_types=1);

namespace Smpl\Logic\Operations;

use Override;
use Smpl\Logic\Contracts\Operation;
use Smpl\Logic\Exceptions\OperationException;

/**
 * Proxy Operation
 *
 * Proxy operations are instances that wrap a callable value, whether that's
 * a closure, first-class-callable, or an invokable class.
 *
 * @package Logic\Operations
 *
 * @template ArgType of mixed
 * @template RetType of mixed
 *
 * @extends \Smpl\Logic\Operations\BaseOperation<ArgType, RetType>
 */
final class ProxyOperation extends BaseOperation
{
    /**
     * The proxy target
     *
     * @var callable(ArgType $arg): RetType
     */
    private $target;

    /**
     * Create a new instance of the proxy operation
     *
     * @param callable(ArgType $arg): RetType $target
     */
    public function __construct(callable $target)
    {
        if ($target instanceof Operation) {
            throw OperationException::recursive();
        }

        $this->target = $target;
    }

    /**
     * Perform the operation
     *
     * This method proxies the call to the stored target.
     *
     * @param ArgType $arg
     *
     * @return RetType
     */
    #[Override]
    public function perform(mixed $arg): mixed
    {
        return call_user_func($this->target, $arg);
    }
}

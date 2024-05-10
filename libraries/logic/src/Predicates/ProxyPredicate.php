<?php
declare(strict_types=1);

namespace Smpl\Logic\Predicates;

use Override;
use Smpl\Logic\Contracts\Predicate;
use Smpl\Logic\Exceptions\PredicateException;

/**
 * Proxy Predicate
 *
 * Proxy predicates are instances that wrap a callable value, whether that's
 * a closure, first-class-callable, or an invokable class.
 *
 * @package Logic\Predicates
 *
 * @template ValType of mixed
 *
 * @extends \Smpl\Logic\Predicates\BasePredicate<ValType>
 */
final class ProxyPredicate extends BasePredicate
{
    /**
     * The callable
     *
     * @var callable(ValType $arg): bool
     */
    private $target;

    /**
     * Create a new instance of the proxy predicate
     *
     * @param callable(ValType $arg): bool $target
     *
     * @throws \Smpl\Logic\Exceptions\PredicateException If the provided target is a predicate
     */
    public function __construct(callable $target)
    {
        if ($target instanceof Predicate) {
            throw PredicateException::recursive();
        }

        $this->target = $target;
    }

    /**
     * Test a value
     *
     * This method proxies the test to a stored target.
     *
     * @param ValType $value
     *
     * @return bool
     */
    #[Override]
    public function test(mixed $value): bool
    {
        return call_user_func($this->target, $value);
    }
}

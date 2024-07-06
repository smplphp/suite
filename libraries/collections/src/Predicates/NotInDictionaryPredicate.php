<?php
declare(strict_types=1);

namespace Smpl\Collections\Predicates;

use Smpl\Logic\Predicates\BasePredicate;

/**
 * @template KeyType of mixed
 * @template ValType of mixed
 *
 * @extends \Smpl\Logic\Predicates\BasePredicate<\Smpl\Collections\Contracts\Dictionary<KeyType, ValType>>
 */
final class NotInDictionaryPredicate extends BasePredicate
{
    /**
     * @var KeyType
     */
    private mixed $key;

    /**
     * @param KeyType $key
     */
    public function __construct(mixed $key)
    {
        $this->key = $key;
    }

    /**
     * Test a value
     *
     * This method should return true if the value passes, and false otherwise.
     *
     * This method should have no side effects, and although it is recommended
     * that implementations simply fail if the value doesn't meet certain
     * criteria, some implementations may throw exceptions.
     *
     * @param \Smpl\Collections\Contracts\Dictionary<KeyType, ValType> $value
     *
     * @return bool
     */
    public function test(mixed $value): bool
    {
        return ! $value->has($this->key);
    }
}

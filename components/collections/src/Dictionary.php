<?php
/** @noinspection PhpUnnecessaryStaticReferenceInspection */
declare(strict_types=1);

namespace Smpl\Collections;

use Override;
use Smpl\Collections\Contracts\Collection;
use Smpl\Logic\Contracts\Comparator;

/**
 * @package  Collections\Dictionary
 *
 * @template KeyType of mixed
 * @template ValType of mixed
 *
 * @implements \Smpl\Collections\Contracts\Dictionary<KeyType, ValType, \Smpl\Collections\Contracts\Pair>
 * @extends \Smpl\Collections\BaseCollection<KeyType, ValType>
 */
final class Dictionary extends BaseCollection implements Contracts\Dictionary
{
    /**
     * @var array<array-key, \Smpl\Collections\Contracts\Pair<KeyType, ValType>>
     */
    protected array $values = [];

    #[Override]
    public function clear(): static
    {
        $this->values = [];
        $this->setCount(0);

        return $this;
    }

    #[Override]
    public function get(mixed $key, mixed $default = null): mixed
    {
        return $this->values[$key] ?? $default;
    }

    #[Override]
    public function has(mixed $key, ?Comparator $comparator = null): bool
    {
        return isset($this->values[$key]);
    }

    #[Override]
    public function hasAll(iterable $keys, ?Comparator $comparator = null): bool
    {
        foreach ($keys as $key) {
            if (! $this->has($key, $comparator)) {
                return false;
            }
        }

        return true;
    }

    #[Override]
    public function keys(): Contracts\Set
    {
        return new Set(array_keys($this->values));
    }

    #[Override]
    public function pairs(): Contracts\Set
    {
        // TODO: Implement pairs() method.
    }

    #[Override]
    public function values(): Collection
    {
        // TODO: Implement values() method.
    }

    #[Override]
    public function copy(): static
    {
        // TODO: Implement copy() method.
    }
}

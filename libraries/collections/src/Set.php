<?php
/** @noinspection PhpUnnecessaryStaticReferenceInspection */
declare(strict_types=1);

namespace Smpl\Collections;

use Override;
use Smpl\Collections\Concerns\CountableCollection;
use Smpl\Logic\Contracts\Comparator;
use Smpl\Logic\Contracts\Predicate;
use Smpl\Logic\Predicates;

/**
 * @package  Collections\Collection
 *
 * @template ValType of mixed
 *
 * @extends \Smpl\Collections\BaseCollection<ValType>
 * @implements \Smpl\Collections\Contracts\Set<ValType>
 */
final class Set extends BaseCollection implements Contracts\Set
{
    use CountableCollection;

    /**
     * Add a value to the collection
     *
     * This method adds a value to the collection, and returns true if the
     * collection was modified, or false otherwise.
     *
     * Implementations of this method should only return false if a value
     * not being added is expected or allowed behaviour, opting to use
     * exceptions in all other cases.
     *
     * @param ValType $value
     *
     * @return bool
     */
    #[Override]
    public function add(mixed $value): bool
    {
        if ($this->contains($value)) {
            return false;
        }

        $this->values[] = $value;
        $this->modifyCount(+1);

        return true;
    }

    /**
     * Create a copy of the collection
     *
     * This method returns a distinct copy of this collection, containing all
     * values and other relevant data.
     *
     * @return static
     */
    #[Override]
    public function copy(): static
    {
        return new static($this->values);
    }
}

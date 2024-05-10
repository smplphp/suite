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
 */
final class Collection extends BaseCollection
{
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

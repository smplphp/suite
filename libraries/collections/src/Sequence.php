<?php
/** @noinspection PhpUnnecessaryStaticReferenceInspection */
declare(strict_types=1);

namespace Smpl\Collections;

use Override;
use Smpl\Collections\Exceptions\InvalidIndexException;
use Smpl\Logic\Contracts\Comparator;

/**
 * @package  Collections\Collection
 *
 * @template ValType of mixed
 *
 * @implements \Smpl\Collections\Contracts\Sequence<ValType>
 * @extends \Smpl\Collections\BaseCollection<ValType>
 */
final class Sequence extends BaseCollection implements Contracts\Sequence
{
    /**
     * @param int  $index
     * @param bool $minInclusive
     * @param bool $maxInclusive
     *
     * @return void
     */
    private function validateIndex(int $index, bool $minInclusive = true, bool $maxInclusive = false): void
    {
        $min      = $minInclusive ? 0 : 1;
        $max      = $maxInclusive ? $this->count() : ($this->count() - 1);
        $absIndex = $index;

        if ($absIndex < $min || $absIndex > $max) {
            throw InvalidIndexException::outOfRange($index, $min, $max);
        }
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

    /**
     * Remove a value from the collection by its index
     *
     * This method removes a value from the collection by its index.
     *
     * This method can be considered the indexed version of {@see self::remove()}.
     *
     * Implementations should ensure that this method only accepts values within
     * the range of [0, n).
     *
     * @param int<0, max> $index
     *
     * @return bool
     *
     * @throws \Smpl\Collections\Exceptions\InvalidIndexException If the provided index is invalid
     */
    #[Override]
    public function forget(int $index): bool
    {
        $this->validateIndex($index);

        if (isset($this->values[$index])) {
            unset($this->values[$index]);
            $this->modifyCount(-1);

            return true;
        }

        return false;
    }

    /**
     * Get a value from the collection by its index
     *
     * This method returns a value at a given index within the collection.
     *
     * Implementations should ensure that this method only accepts values within
     * the range of [0, n).
     *
     * @param int<0, max> $index
     *
     * @return ValType|null
     *
     * @throws \Smpl\Collections\Exceptions\InvalidIndexException If the provided index is invalid
     */
    #[Override]
    public function get(int $index): mixed
    {
        $this->validateIndex($index);

        return $this->values[$index] ?? null;
    }

    /**
     * Get the index of a value
     *
     * This method returns the current index for a given value, if found, or
     * false otherwise.
     * This method also accepts an optional {@see \Smpl\Logic\Contracts\Comparator}
     * to determine whether a value matches.
     *
     * This method will only return the index for the first matching value.
     *
     * @param ValType                                        $value
     * @param \Smpl\Logic\Contracts\Comparator<ValType>|null $comparator
     *
     * @return int<0, max>|false
     *
     * @psalm-suppress LessSpecificImplementedReturnType
     */
    #[Override]
    public function indexOf(mixed $value, ?Comparator $comparator = null): int|false
    {
        if ($comparator === null) {
            return array_search($value, $this->values, true);
        }

        foreach ($this->values as $index => $storedElement) {
            if ($comparator->compare($value, $storedElement) === 0) {
                return $index;
            }
        }

        return false;
    }

    /**
     * Insert a value at an index
     *
     * This method inserts a given value at a given index if the index is
     * valid, returning true of the collection was modified, and false otherwise.
     *
     * Indexes for insertion should be within the range of [0, n].
     * If the provided index is within the range of [0, n), the value currently
     * at that index will be shifted right by one.
     * If the provided index is n, then this method should function identically
     * to {@see self::add()}.
     *
     * @param int<0, max> $index
     * @param ValType     $value
     *
     * @return bool
     *
     * @throws \Smpl\Collections\Exceptions\InvalidIndexException If the provided index is invalid
     */
    #[Override]
    public function insert(int $index, mixed $value): bool
    {
        $this->validateIndex($index, true, true);

        if ($index === $this->count()) {
            return $this->add($value);
        }

        array_splice($this->values, $index, 0, [$value]);
        $this->modifyCount(1);

        return true;
    }

    /**
     * Insert multiple values start at an index
     *
     * This method inserts multiple values into the collection starting at a
     * given index if the index is valid, returning true if the collection was
     * modified, and false otherwise.
     * Elements are inserted at the index i+x, where i is the provided index, and
     * x is its order in the provided values.
     * For example, the first value will be inserted at i+0, then the next i+1,
     * and so on and so forth.
     *
     * Indexes for insertion should be within the range of [0, n].
     * If the provided index is within the range of [0, n), all values that exist
     * at indexes that would be overlapped, will be shifted right 1 for each value
     * that is inserted.
     * If the provided index is n, then this method should function identically
     * to {@see self::addAll()}.
     *
     * @param int<0, max>       $index
     * @param iterable<ValType> $values
     *
     * @return bool
     *
     * @throws \Smpl\Collections\Exceptions\InvalidIndexException If the provided index is invalid
     */
    #[Override]
    public function insertAll(int $index, iterable $values): bool
    {
        $modified = false;

        foreach ($values as $value) {
            $this->validateIndex($index, true, true);

            if ($this->insert($index, $value)) {
                $modified = true;
                $index++;
            }
        }

        return $modified;
    }

    /**
     * Sets the value for an index
     *
     * This method sets the value at a given index, if the index is valid,
     * returning true of the collection was modified, and false otherwise.
     * Indexes should be within the range of [0, n), and if a value
     * exists at the current index, it will be replaced.
     *
     * This method should not change the size of the collection.
     *
     * @param int<0, max> $index
     * @param mixed       $value
     *
     * @return bool
     *
     * @throws \Smpl\Collections\Exceptions\InvalidIndexException If the provided index is invalid
     */
    #[Override]
    public function set(int $index, mixed $value): bool
    {
        $this->validateIndex($index);

        $this->values[$index] = $value;

        return true;
    }

    /**
     * Sort the collection using a comparator
     *
     * This method sorts all values within the collection using the provided
     * {@see \Smpl\Logic\Contracts\Comparator}.
     * While it's possible that the order of the values within the collection
     * remains the same, it should be assumed that all values will have
     * different indexes after this operation.
     *
     * @param \Smpl\Logic\Contracts\Comparator<ValType> $comparator
     *
     * @return static
     */
    #[Override]
    public function sort(Comparator $comparator): static
    {
        usort($this->values, $comparator);

        return $this;
    }

    /**
     * Create a new collection from a slice of the collection
     *
     * This method creates a new collection containing only values within
     * the provided range.
     *
     * Implementations of this method will differ.
     * However, both the index and count should follow the rules of offset
     * and length for the {@see \array_slice()} function.
     *
     * If the index is positive, the slice will start at that index, and if it's
     * negative, it will start that many values from the end of the collection.
     *
     * If count is positive, and within the range of (0, n], that many values
     * will be contained within the resulting collection.
     * If count is negative, and within the range of [-n, 0), the new collection
     * will contain all values from the given index, to this number of values
     * from the end.
     *
     * @param int      $index
     * @param int|null $count
     *
     * @return static
     *
     * @throws \Smpl\Collections\Exceptions\InvalidIndexException If the index is invalid
     */
    #[Override]
    public function slice(int $index, ?int $count = null): static
    {
        // TODO: Find a better way to validate the indexes
        $slice = array_slice($this->values, $index, $count);

        return new static($slice);
    }
}

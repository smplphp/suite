<?php

namespace Smpl\Collections\Contracts;

use Smpl\Logic\Contracts\Comparator;

/**
 * Sequence
 *
 * Sequences are collections that are indexed sequentially, with indexes changing
 * as and when required.
 * Because of this, it is not safe to rely on a values' index, as that index
 * is subject to change.
 *
 * Sequences are always indexed in a range of [0, n), where n is the number of
 * values within the sequence.
 * This means that when appending a new value to the end of the sequence, its
 * index will be n-1.
 *
 * @package Collections\Collection
 *
 * @template ValType of mixed
 *
 * @extends \Smpl\Collections\Contracts\Collection<ValType>
 */
interface Sequence extends Collection
{
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
    public function forget(int $index): bool;

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
    public function get(int $index): mixed;

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
     */
    public function indexOf(mixed $value, ?Comparator $comparator = null): int|false;

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
     * @param ValType      $value
     *
     * @return bool
     *
     * @throws \Smpl\Collections\Exceptions\InvalidIndexException If the provided index is invalid
     */
    public function insert(int $index, mixed $value): bool;

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
     * @param int<0, max>      $index
     * @param iterable<ValType> $values
     *
     * @return bool
     *
     * @throws \Smpl\Collections\Exceptions\InvalidIndexException If the provided index is invalid
     */
    public function insertAll(int $index, iterable $values): bool;

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
    public function set(int $index, mixed $value): bool;

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
    public function sort(Comparator $comparator): static;

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
    public function slice(int $index, ?int $count = null): static;
}

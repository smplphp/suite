<?php

namespace Smpl\Collections\Contracts;


use Countable;
use IteratorAggregate;
use Smpl\Logic\Contracts\Comparator;
use Smpl\Logic\Contracts\Predicate;

/**
 * Collection
 *
 * Collections represent list-style arrays, containing zero or more values of a
 * given type, with an integer key.
 * By default, collections do not provide a method of interacting with the values
 * via their key, though some implementations mad do.
 *
 * @package  Collections\Collection
 *
 * @template ValType of mixed
 *
 * @extends \IteratorAggregate<int, ValType>
 */
interface Collection extends Countable, IteratorAggregate
{
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
    public function add(mixed $value): bool;

    /**
     * Add multiple values to the collection
     *
     * This method adds multiple values to the collection, and returns true if
     * the collection was modified, or false otherwise.
     *
     * It should be noted that this method returning true does not mean that all
     * values were added, just that the collection itself was modified as a
     * result.
     *
     * It is recommended that implementations of this method utilise the
     * {@see self::add()} method, following its rules and conventions.
     *
     * @param iterable<ValType> $values
     *
     * @return bool
     */
    public function addAll(iterable $values): bool;

    /**
     * Clear the collection
     *
     * This method clears the collection, removing all values currently stored
     * within.
     *
     * @return static
     */
    public function clear(): static;

    /**
     * Check if a value is contained in the collection
     *
     * This method checks to see if the provided value is present within the
     * collection, returning true if it is, and false otherwise.
     * This method also accepts an optional {@see \Smpl\Logic\Contracts\Comparator}
     * to determine whether a value is considered present.
     *
     * Implementations of this method will define their own comparison logic for
     * situations where no comparator is provided.
     *
     * @param ValType                                        $value
     * @param \Smpl\Logic\Contracts\Comparator<ValType>|null $comparator
     *
     * @return bool
     */
    public function contains(mixed $value, ?Comparator $comparator = null): bool;

    /**
     * Check if multiple values are contained in the collection
     *
     * This method checks to see if the provided values are all present within
     * the collection, returning true if they are, and false if one or more are
     * not.
     * This method also accepts an optional {@see \Smpl\Logic\Contracts\Comparator}
     * to determine whether a value is present.
     *
     * It is recommended that implementations of this method utilise the
     * {@see self::contains()} method, following its rules and conventions.
     *
     * @param iterable<ValType>                              $values
     * @param \Smpl\Logic\Contracts\Comparator<ValType>|null $comparator
     *
     * @return bool
     */
    public function containsAll(iterable $values, ?Comparator $comparator = null): bool;

    /**
     * Create a copy of the collection
     *
     * This method returns a distinct copy of this collection, containing all
     * values and other relevant data.
     *
     * @return static
     */
    public function copy(): static;

    /**
     * Count the object
     *
     * This method returns the 'count' of the object, typically meaning it will
     * return the current number of values.
     *
     * @return int<0, max>
     */
    public function count(): int;

    /**
     * Check if the collection is empty
     *
     * This method returns true if the collection is empty, and false otherwise.
     *
     * Implementations should ensure that if this method returns true,
     * {@see self::isNotEmpty()} returns false, and {@see self::count()} returns 0.
     *
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * Check if the collection is not empty
     *
     * This method returns true if the collection is not empty, and false otherwise.
     *
     * Implementations should ensure that if this method returns true,
     * {@see self::isEmpty()} returns false, and {@see self::count()} returns a
     * value greater than 0.
     *
     * @return bool
     */
    public function isNotEmpty(): bool;

    /**
     * Remove a value from the collection
     *
     * This method removes a value from the collection, and returns true if the
     * collection was modified, or false otherwise.
     * This method also accepts an optional {@see \Smpl\Logic\Contracts\Comparator}
     * to determine whether a value should be removed.
     *
     * It is recommended that implementations of this method only remove the
     * first match within the collection, though some implementations may remove
     * every matching value.
     *
     * @param ValType                                        $value
     * @param \Smpl\Logic\Contracts\Comparator<ValType>|null $comparator
     *
     * @return bool
     */
    public function remove(mixed $value, ?Comparator $comparator = null): bool;

    /**
     * Remove multiple values from the collection
     *
     * This method removes multiple values from the collection, and returns
     * true if the collection was modified, or false otherwise.
     * This method also accepts an optional {@see \Smpl\Logic\Contracts\Comparator}
     * to determine whether a value should be removed.
     *
     * It should be noted that this method returning true does not mean that all
     * values were removed, just that the collection itself was modified as a
     * result.
     *
     * It is recommended that implementations of this method utilise the
     * {@see self::remove()} method, following its rules and conventions.
     *
     * @param iterable<ValType>                              $values
     * @param \Smpl\Logic\Contracts\Comparator<ValType>|null $comparator
     *
     * @return bool
     */
    public function removeAll(iterable $values, ?Comparator $comparator = null): bool;

    /**
     * Remove multiple values that meet the criteria
     *
     * This method removes all values from the collection that pass the provided
     * {@see \Smpl\Logic\Contracts\Predicate}.
     *
     * @param \Smpl\Logic\Contracts\Predicate<ValType> $predicate
     *
     * @return bool
     */
    public function removeIf(Predicate $predicate): bool;

    /**
     * Retain multiple values in the collection
     *
     * This method removes all values from the collection that do not match
     * the provided collection of values.
     * This method also accepts an optional {@see \Smpl\Logic\Contracts\Comparator}
     * to determine whether a value should be removed.
     *
     * It should be noted that this method returning true does not mean that all
     * values were present, just that the collection itself was modified as a
     * result.
     *
     * This method is considered the inverse of {@see self::remove()}.
     *
     * @param iterable<ValType>                              $values
     * @param \Smpl\Logic\Contracts\Comparator<ValType>|null $comparator
     *
     * @return bool
     */
    public function retainAll(iterable $values, ?Comparator $comparator = null): bool;

    /**
     * Retain multiple values that meet the criteria
     *
     * This method removes all values from the collection that do not pass the
     * provided {@see \Smpl\Logic\Contracts\Predicate}.
     *
     * This method is considered the inverse of {@see self::removeIf()}.
     *
     * @param \Smpl\Logic\Contracts\Predicate<ValType> $predicate
     *
     * @return bool
     */
    public function retainIf(Predicate $predicate): bool;

    /**
     * Convert the object into an array
     *
     * Returns an array consisting of the values stored within the enumerable object.
     *
     * @return array<int, ValType>
     */
    public function toArray(): array;
}

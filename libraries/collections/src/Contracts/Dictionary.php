<?php

namespace Smpl\Collections\Contracts;

use Countable;
use IteratorAggregate;
use Smpl\Logic\Contracts\BinaryPredicate;
use Smpl\Logic\Contracts\Comparator;
use Smpl\Logic\Contracts\Operation;
use Smpl\Logic\Contracts\Predicate;

/**
 * Dictionary
 *
 * Dictionaries represent keyed-arrays, typically keyed by string, though some
 * implementations allow for objects to be used as keys.
 *
 * @package  Collections\Dictionary
 *
 * @template KeyType of mixed
 * @template ValType of mixed
 *
 * @extends \IteratorAggregate<KeyType, ValType>
 */
interface Dictionary extends Countable, IteratorAggregate
{
    /**
     * Clear the dictionary
     *
     * This method clears the dictionary, removing all elements currently stored
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
     * @param mixed $key
     *
     * @return bool
     */
    public function forget(mixed $key): bool;

    /**
     * Get a value from the dictionary
     *
     * This method returns a value stored in the dictionary for a given key.
     * If no value was found, the default value will be returned.
     *
     * @param KeyType      $key
     * @param KeyType|null $default
     *
     * @return ValType|null
     */
    public function get(mixed $key, mixed $default = null): mixed;

    /**
     * Check if a key is present within the dictionary
     *
     * This method checks the dictionary for the presence of a provided key,
     * returning true if it was found, and false otherwise.
     * This method also accepts an optional {@see \Smpl\Logic\Contracts\Comparator}
     * to determine whether a key is present.
     *
     * This method is the key variation of {@see self::contains()}.
     *
     * @param KeyType                                        $key
     * @param \Smpl\Logic\Contracts\Comparator<KeyType>|null $comparator
     *
     * @return bool
     */
    public function has(mixed $key, ?Comparator $comparator = null): bool;

    /**
     * Check if multiple keys are present within the dictionary
     *
     * This method checks to see if the provided keys are all present within
     * the collection, returning true if they are, and false if one or more are
     * not.
     * This method also accepts an optional {@see \Smpl\Logic\Contracts\Comparator}
     * to determine whether a key is present.
     *
     * It is recommended that implementations of this method utilise the
     * {@see self::has()} method, following its rules and conventions.
     *
     * @param iterable<KeyType>                              $keys
     * @param \Smpl\Logic\Contracts\Comparator<KeyType>|null $comparator
     *
     * @return bool
     */
    public function hasAll(iterable $keys, ?Comparator $comparator = null): bool;

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
     * Get a collection of the keys present within the dictionary
     *
     * This method returns a {@see \Smpl\Collections\Contracts\Set} containing
     * all keys currently mapped within the dictionary.
     *
     * @return \Smpl\Collections\Contracts\Set<KeyType>
     */
    public function keys(): Set;

    /**
     * Put a key value pair into the dictionary
     *
     * This method maps the provided value to the provided key within the
     * dictionary.
     *
     * By default, any existing mapping for a given key will be overwritten,
     * and any implementation that behaves differently must state it.
     *
     * @param KeyType $key
     * @param ValType $value
     *
     * @return static
     */
    public function put(mixed $key, mixed $value): static;

    /**
     * Put multiple key value pairs into the dictionary
     *
     * This method maps the provided values to the provided key within the
     * dictionary.
     *
     * By default, any existing mapping for a given key will be overwritten,
     * and any implementation that behaves differently must state it.
     *
     * @param iterable<KeyType, ValType> $values
     *
     * @return static
     */
    public function putAll(iterable $values): static;

    /**
     * Put a key value pair into the dictionary if the dictionary passes a predicate
     *
     * This method maps the provided value to the provided key within the
     * dictionary, if the dictionary itself passes the provided predicate.
     *
     * This method returns true if the predicate passed, otherwise it returns
     * false.
     * Returning true does not guarantee that the value was successfully mapped,
     * only that the predicate was passed.
     *
     * By default, any existing mapping for a given key will be overwritten,
     * and any implementation that behaves differently must state it.
     *
     * @param KeyType                                 $key
     * @param ValType                                 $value
     * @param \Smpl\Logic\Contracts\Predicate<static> $predicate
     *
     * @return bool
     */
    public function putIf(mixed $key, mixed $value, Predicate $predicate): bool;

    /**
     * Put a key value pair into the dictionary if the key isn't already present
     *
     * This method maps the provided value to the provided key within the
     * dictionary if the key isn't already present.
     * Returning true does not guarantee that the value was successfully mapped,
     * only that the key wasn't already present.
     *
     * This method returns true if the key wasn't present, or false otherwise.
     *
     * @param KeyType $key
     * @param ValType $value
     *
     * @return bool
     */
    public function putIfAbsent(mixed $key, mixed $value): bool;

    /**
     * Removes any key value mappings from the dictionary, for the provided value
     *
     * This method removes all mappings from the dictionary for the provided value.
     * If a comparator is provided, it will be used to determine whether a
     * mapped value should be removed.
     *
     * This method returns true if the dictionary was modified, and false
     * otherwise.
     *
     * @param ValType                                        $value
     * @param \Smpl\Logic\Contracts\Comparator<ValType>|null $comparator
     *
     * @return bool
     */
    public function remove(mixed $value, ?Comparator $comparator = null): bool;

    /**
     * Removes any key value mappings from the dictionary, for the provided values
     *
     * This method removes all mappings from the dictionary for the provided values.
     * If a comparator is provided, it will be used to determine whether a
     * mapped value should be removed.
     *
     * This method returns true if the dictionary was modified, and false
     * otherwise.
     *
     * This method is the inverse of {@see self::retainAll()}.
     *
     * @param ValType                                        $values
     * @param \Smpl\Logic\Contracts\Comparator<ValType>|null $comparator
     *
     * @return bool
     */
    public function removeAll(iterable $values, ?Comparator $comparator = null): bool;

    /**
     * Removes any key value mappings from the dictionary that pass the provided predicate
     *
     * This method removes all mappings from the dictionary that pass the
     * provided predicate.
     *
     * This method returns true if the dictionary was modified, and false
     * otherwise.
     *
     * This method is the inverse of {@see self::retainIf()}.
     *
     * @param \Smpl\Logic\Contracts\Predicate<\Smpl\Collections\Contracts\Pair<KeyType, ValType>>|\Smpl\Logic\Contracts\BinaryPredicate<KeyType, ValType> $predicate
     *
     * @return bool
     */
    public function removeIf(Predicate|BinaryPredicate $predicate): bool;

    /**
     * Retains any key value mappings in the dictionary, that match the provided values
     *
     * This method removes all mappings from the dictionary that do not match
     * the provided values.
     * If a comparator is provided, it will be used to determine whether a
     * mapped value should be removed.
     *
     * This method returns true if the dictionary was modified, and false
     * otherwise.
     *
     * This method is the inverse of {@see self::removeAll()}.
     *
     * @param iterable<ValType>                              $values
     * @param \Smpl\Logic\Contracts\Comparator<ValType>|null $comparator
     *
     * @return bool
     */
    public function retainAll(iterable $values, ?Comparator $comparator = null): bool;

    /**
     * Retains any key value mappings from the dictionary that pass the provided predicate
     *
     * This method removes all mappings from the dictionary do not pass the
     * provided predicate.
     *
     * This method returns true if the dictionary was modified, and false
     * otherwise.
     *
     * This method is the inverse of {@see self::retainIf()}.
     *
     * @param \Smpl\Logic\Contracts\Predicate<\Smpl\Collections\Contracts\Pair<KeyType, ValType>>|\Smpl\Logic\Contracts\BinaryPredicate<KeyType, ValType> $predicate
     *
     * @return bool
     */
    public function retainIf(Predicate|BinaryPredicate $predicate): bool;

    /**
     * Convert the object into an array
     *
     * Returns an array consisting of the values stored within the enumerable object.
     * This method also accepts an optional {@see \Smpl\Logic\Contracts\Operation}
     * that can be used to convert the current key to a valid array key.
     *
     * Some implementations will have a default method of converting keys to valid
     * array keys, and some will simply throw exceptions.
     *
     * @param \Smpl\Logic\Contracts\Operation<KeyType, array-key>|null $keyConverter
     *
     * @return array<KeyType|array-key, ValType>
     */
    public function toArray(Operation $keyConverter = null): array;

    /**
     * Get a collection of the values in the dictionary
     *
     * This method returns a {@see \Smpl\Collections\Contracts\Collection}
     * containing the values contained in the dictionary.
     *
     * @return \Smpl\Collections\Contracts\Collection<ValType>
     */
    public function values(): Collection;
}

<?php
/** @noinspection PhpUnnecessaryStaticReferenceInspection */
declare(strict_types=1);

namespace Smpl\Collections;

use ArrayIterator;
use Exception;
use Smpl\Collections\Concerns\CountableCollection;
use Smpl\Collections\Predicates\NotInDictionaryPredicate;
use Smpl\Logic\Contracts\BinaryPredicate;
use Smpl\Logic\Contracts\Comparator;
use Smpl\Logic\Contracts\Operation;
use Smpl\Logic\Contracts\Predicate;
use Traversable;

/**
 * @package  Collections\Dictionary
 *
 * @template KeyType of array-key
 * @template ValType of mixed
 *
 * @implements \Smpl\Collections\Contracts\Dictionary<KeyType, ValType>
 */
final class Dictionary implements Contracts\Dictionary
{
    use CountableCollection;

    /**
     * @var array<KeyType, ValType>
     */
    private array $mapping = [];

    /**
     * Create a new instance of the dictionary
     *
     * @param iterable<KeyType, ValType> $mapping
     */
    public function __construct(iterable $mapping = [])
    {
        if (is_array($mapping)) {
            $this->mapping = $mapping;
            $this->setCount(count($mapping));
        } else {
            foreach ($mapping as $key => $value) {
                $this->put($key, $value);
            }
        }
    }

    /**
     * Retrieve an external iterator
     *
     * @link           https://php.net/manual/en/iteratoraggregate.getiterator.php
     *
     * @return Traversable<KeyType, ValType>|ValType[] An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @throws Exception on failure.
     *
     * @psalm-suppress ImplementedReturnTypeMismatch
     * @psalm-suppress MismatchingDocblockReturnType
     * @psalm-suppress MixedInferredReturnType
     * @noinspection   PhpDocSignatureInspection
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->mapping);
    }

    /**
     * Clear the dictionary
     *
     * This method clears the dictionary, removing all elements currently stored
     * within.
     *
     * @return static
     */
    public function clear(): static
    {
        $this->mapping = [];
        $this->setCount(0);

        return $this;
    }

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
    public function contains(mixed $value, ?Comparator $comparator = null): bool
    {
        if ($comparator === null) {
            return in_array($value, $this->mapping, true);
        }

        foreach ($this->mapping as $mappedValue) {
            if ($comparator->compare($value, $mappedValue) === 0) {
                return true;
            }
        }

        return false;
    }

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
    public function containsAll(iterable $values, ?Comparator $comparator = null): bool
    {
        foreach ($values as $value) {
            if (! $this->contains($value, $comparator)) {
                return false;
            }
        }

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
    public function copy(): static
    {
        $copy          = new self();
        $copy->mapping = $this->mapping;
        $copy->count   = $this->count;

        return $copy;
    }

    /**
     * @param KeyType $key
     *
     * @return bool
     */
    public function forget(mixed $key): bool
    {
        if (isset($this->mapping[$key])) {
            unset($this->mapping[$key]);
            $this->modifyCount(-1);

            return true;
        }

        return false;
    }

    /**
     * Get a value from the dictionary
     *
     * This method returns a value stored in the dictionary for a given key.
     * If no value was found, the default value will be returned.
     *
     * @param KeyType      $key
     * @param ValType|null $default
     *
     * @return ValType|null
     *
     * @psalm-suppress InvalidReturnType
     */
    public function get(mixed $key, mixed $default = null): mixed
    {
        return $this->mapping[$key] ?? $default;
    }

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
    public function has(mixed $key, ?Comparator $comparator = null): bool
    {
        if ($comparator === null) {
            return isset($this->mapping[$key]);
        }

        foreach ($this->mapping as $mappedKey => $mappedValue) {
            if ($comparator->compare($mappedKey, $key) === 0) {
                return true;
            }
        }

        return false;
    }

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
    public function hasAll(iterable $keys, ?Comparator $comparator = null): bool
    {
        foreach ($keys as $key) {
            if (! $this->has($key, $comparator)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get a collection of the keys present within the dictionary
     *
     * This method returns a {@see \Smpl\Collections\Contracts\Set} containing
     * all keys currently mapped within the dictionary.
     *
     * @return \Smpl\Collections\Contracts\Set<KeyType>
     */
    public function keys(): Contracts\Set
    {
        return new Set(array_keys($this->mapping));
    }

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
    public function put(mixed $key, mixed $value): static
    {
        if (! $this->has($key)) {
            $this->modifyCount(1);
        }

        $this->mapping[$key] = $value;

        return $this;
    }

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
    public function putAll(iterable $values): static
    {
        foreach ($values as $key => $value) {
            $this->put($key, $value);
        }

        return $this;
    }

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
     * @param KeyType                                                 $key
     * @param ValType                                                 $value
     * @param \Smpl\Logic\Contracts\Predicate<self<KeyType, ValType>> $predicate
     *
     * @return bool
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function putIf(mixed $key, mixed $value, Predicate $predicate): bool
    {
        if ($predicate->test($this) === true) {
            $this->put($key, $value);

            return true;
        }

        return false;
    }

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
    public function putIfAbsent(mixed $key, mixed $value): bool
    {
        /**
         * @psalm-suppress ArgumentTypeCoercion
         */
        return $this->putIf(
            $key,
            $value,
            new NotInDictionaryPredicate($key)
        );
    }

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
    public function remove(mixed $value, ?Comparator $comparator = null): bool
    {
        $modified = false;

        foreach ($this->mapping as $mappedKey => $mappedValue) {
            if ($comparator === null) {
                if ($value === $mappedValue) {
                    $this->forget($mappedKey);
                    $modified = true;
                }
            } else if ($comparator->compare($value, $mappedValue) === 0) {
                $this->forget($mappedKey);
                $modified = true;
            }
        }

        return $modified;
    }

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
     * @param iterable<ValType>                              $values
     * @param \Smpl\Logic\Contracts\Comparator<ValType>|null $comparator
     *
     * @return bool
     */
    public function removeAll(iterable $values, ?Comparator $comparator = null): bool
    {
        $modified = false;

        foreach ($values as $value) {
            $modified = $this->remove($value, $comparator);
        }

        return $modified;
    }

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
     * @noinspection DuplicatedCode
     */
    public function removeIf(BinaryPredicate|Predicate $predicate): bool
    {
        $modified = false;

        /**
         * @var KeyType $mappedKey
         * @var ValType $mappedValue
         */
        foreach ($this->mapping as $mappedKey => $mappedValue) {
            if ($predicate instanceof BinaryPredicate) {
                /** @psalm-suppress InvalidArgument */
                if ($predicate->test($mappedKey, $mappedValue) === true) {
                    $this->forget($mappedKey);
                    $modified = true;
                }
            } else if ($predicate->test(new Pair($mappedKey, $mappedValue)) === true) {
                $this->forget($mappedKey);
                $modified = true;
            }
        }

        return $modified;
    }

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
    public function retainAll(iterable $values, ?Comparator $comparator = null): bool
    {
        $modified   = false;
        $collection = new Set($values);

        foreach ($this->mapping as $mappedKey => $mappedValue) {
            if ($collection->contains($mappedValue, $comparator)) {
                $this->forget($mappedKey);
                $modified = true;
            }
        }

        return $modified;
    }

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
     * @noinspection DuplicatedCode
     */
    public function retainIf(BinaryPredicate|Predicate $predicate): bool
    {
        $modified = false;

        foreach ($this->mapping as $mappedKey => $mappedValue) {
            if ($predicate instanceof BinaryPredicate) {
                /** @psalm-suppress InvalidArgument */
                if ($predicate->test($mappedKey, $mappedValue) === false) {
                    $this->forget($mappedKey);
                    $modified = true;
                }
            } else if ($predicate->test(new Pair($mappedKey, $mappedValue)) === false) {
                $this->forget($mappedKey);
                $modified = true;
            }
        }

        return $modified;
    }

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
    public function toArray(Operation $keyConverter = null): array
    {
        return $this->mapping;
    }

    /**
     * Get a collection of the values in the dictionary
     *
     * This method returns a {@see \Smpl\Collections\Contracts\Collection}
     * containing the values contained in the dictionary.
     *
     * @return \Smpl\Collections\Contracts\Collection<ValType>
     */
    public function values(): Contracts\Collection
    {
        /**
         * @var \Smpl\Collections\Set<ValType> $values
         */
        $values = new Set(array_values($this->mapping));

        return $values;
    }
}

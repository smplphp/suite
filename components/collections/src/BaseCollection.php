<?php
declare(strict_types=1);

namespace Smpl\Collections;

use ArrayIterator;
use Override;
use Smpl\Collections\Concerns\CountableCollection;
use Smpl\Logic\Contracts\Comparator;
use Smpl\Logic\Contracts\Operation;
use Smpl\Logic\Contracts\Predicate;
use Smpl\Logic\Predicates;
use Traversable;

/**
 * @package  Collections
 *
 * @template ValType of mixed
 *
 * @implements \Smpl\Collections\Contracts\Collection<ValType>
 */
abstract class BaseCollection implements Contracts\Collection
{
    use CountableCollection;

    /**
     * @var array<int<0, max>, ValType>
     */
    protected array $values = [];

    /**
     * @param iterable<ValType> $values
     */
    public function __construct(iterable $values = [])
    {
        if (! empty($values)) {
            $this->addAll($values);
        }
    }

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
        $this->values[] = $value;
        $this->modifyCount(+1);

        return true;
    }

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
    #[Override]
    public function addAll(iterable $values): bool
    {
        foreach ($values as $value) {
            $this->add($value);
        }

        return true;
    }

    /**
     * Clear the collection
     *
     * This method clears the collection, removing all values currently stored
     * within.
     *
     * @return static
     */
    #[Override]
    public function clear(): static
    {
        $this->values = [];
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
    #[Override]
    public function contains(mixed $value, ?Comparator $comparator = null): bool
    {
        if ($comparator === null) {
            return in_array($value, $this->values, true);
        }

        foreach ($this->values as $storedElement) {
            if ($comparator->compare($value, $storedElement) === 0) {
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
     * to determine whether a value is considered present.
     *
     * It is recommended that implementations of this method utilise the
     * {@see self::contains()} method, following its rules and conventions.
     *
     * @param iterable<ValType>                              $values
     * @param \Smpl\Logic\Contracts\Comparator<ValType>|null $comparator
     *
     * @return bool
     */
    #[Override]
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
     * Retrieve an external iterator
     *
     * @link           https://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable<int, ValType> An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     *
     * @psalm-suppress InvalidReturnType
     * @psalm-suppress InvalidReturnStatement
     */
    #[Override]
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->values);
    }

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
    #[Override]
    public function remove(mixed $value, ?Comparator $comparator = null): bool
    {
        $index = $this->findElementIndex($value, $comparator);

        if ($index !== false) {
            return $this->removeByIndex($index);
        }

        return false;
    }

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
    #[Override]
    public function removeAll(iterable $values, ?Comparator $comparator = null): bool
    {
        $modified = false;

        foreach ($values as $value) {
            if ($this->remove($value, $comparator)) {
                $modified = true;
            }
        }

        return $modified;
    }

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
    #[Override]
    public function removeIf(Predicate $predicate): bool
    {
        $modified = false;

        foreach ($this->values as $index => $value) {
            if ($predicate->test($value) && $this->removeByIndex($index)) {
                $modified = true;
            }
        }

        return $modified;
    }

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
    #[Override]
    public function retainAll(iterable $values, ?Comparator $comparator = null): bool
    {
        $modified    = false;
        $retained    = new Collection($values);
        $newElements = [];

        foreach ($this->values as $storedElement) {
            if ($retained->contains($storedElement, $comparator)) {
                $newElements[] = $storedElement;
                $modified      = true;
            }
        }

        $this->values = $newElements;
        $this->setCount(count($newElements));

        return $modified;
    }

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
    #[Override]
    public function retainIf(Predicate $predicate): bool
    {
        return $this->removeIf(Predicates::negate($predicate));
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
     * @param \Smpl\Logic\Contracts\Operation<int, array-key>|null $keyConverter
     *
     * @return array<int|array-key, ValType>
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    #[Override]
    public function toArray(Operation $keyConverter = null): array
    {
        if ($keyConverter !== null) {
            $array = [];

            foreach ($this->values as $key => $value) {
                $array[$keyConverter->perform($key)] = $value;
            }

            return $array;
        }

        return $this->values;
    }

    /**
     * @param ValType                                        $value
     * @param \Smpl\Logic\Contracts\Comparator<ValType>|null $comparator
     *
     * @return int|false
     */
    protected function findElementIndex(mixed $value, ?Comparator $comparator): false|int
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
     * @param int $index
     *
     * @return bool
     */
    protected function removeByIndex(int $index): bool
    {
        if (isset($this->values[$index])) {
            unset($this->values[$index]);
            $this->modifyCount(-1);

            return true;
        }

        return false;
    }
}

<?php
declare(strict_types=1);

namespace Smpl\Collections\Concerns;

/**
 *
 */
trait CountableCollection
{
    /**
     * @var int<0, max>
     */
    private int $count = 0;

    /**
     * @return int<0, max>
     */
    public function count(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     *
     * @return int<0, max>
     */
    protected function setCount(int $count): int
    {
        $this->count = max(0, $count);

        return $this->count;
    }

    /**
     * @param int $modifier
     *
     * @return int<0, max>
     */
    protected function modifyCount(int $modifier): int
    {
        return $this->setCount($this->count + $modifier);
    }

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
    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

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
    public function isNotEmpty(): bool
    {
        return ! $this->isEmpty();
    }
}

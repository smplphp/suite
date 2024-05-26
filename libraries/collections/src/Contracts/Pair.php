<?php

namespace Smpl\Collections\Contracts;

/**
 * @template KeyType of mixed
 * @template ValType of mixed
 */
interface Pair
{
    /**
     * Get the pairs key
     *
     * @return KeyType
     */
    public function key(): mixed;

    /**
     * Get the pairs value
     *
     * @return ValType
     */
    public function value(): mixed;
}

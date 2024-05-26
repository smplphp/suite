<?php

namespace Smpl\Collections;

/**
 * @template KeyType of mixed
 * @template ValType of mixed
 */
final class Pair implements Contracts\Pair
{
    /**
     * @var KeyType
     */
    private mixed $key;

    /**
     * @var ValType
     */
    private mixed $value;

    public function __construct(mixed $key, mixed $value)
    {
        $this->key   = $key;
        $this->value = $value;
    }

    /**
     * Get the pairs key
     *
     * @return KeyType
     */
    public function key(): mixed
    {
        return $this->key;
    }

    /**
     * Get the pairs value
     *
     * @return ValType
     */
    public function value(): mixed
    {
        return $this->value;
    }
}

<?php

namespace Smpl\Logic\Contracts;

/**
 * Consumer
 *
 * Consumers take a single argument and return no value.
 * In essence, they consume the value provided.
 * What the consumer does with the value it is given is entirely down to the
 * implementation.
 *
 * @package Logic\Consumers
 *
 * @template ValType of mixed
 */
interface Consumer
{
    /**
     * Consume a value
     *
     * @param ValType $arg
     *
     * @return void
     */
    public function consume(mixed $arg): void;
}

<?php

namespace Smpl\Logic\Contracts;

/**
 * Supplier
 *
 * Suppliers provide their caller with a value.
 * They take no arguments, so aren't compatible with
 * {@see \Smpl\Logic\Contracts\Operation}.
 *
 * @package Logic\Suppliers
 *
 * @template RetType of mixed
 */
interface Supplier
{
    /**
     * Get a value
     *
     * @return RetType
     */
    public function get(): mixed;
}

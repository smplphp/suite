<?php

namespace Smpl\Reflection\Contracts;

/**
 *
 */
interface Type
{
    /**
     * Get the name of the type
     *
     * @return string
     */
    public function name(): string;

    /**
     * Check if this type is assignable to the provided
     *
     * @param \Smpl\Reflection\Contracts\Type $type
     *
     * @return bool
     */
    public function assignableTo(Type $type): bool;

    /**
     * Check if this type is assignable from the provided
     *
     * @param \Smpl\Reflection\Contracts\Type $type
     *
     * @return bool
     */
    public function assignableFrom(Type $type): bool;

    /**
     * Check if this type is equal to the provided
     *
     * @param \Smpl\Reflection\Contracts\Type $type
     *
     * @return bool
     */
    public function is(Type $type): bool;

    /**
     * Check if the provided value is of this type
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function matches(mixed $value): bool;
}

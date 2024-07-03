<?php

namespace Smpl\DI\Contracts;

/**
 * @template BindingAbstract of object
 */
interface BindingBuilder
{
    /**
     * @param class-string<BindingAbstract>|object<BindingAbstract>|callable(): BindingAbstract $concrete
     *
     * @return static
     */
    public function to(string|object|callable $concrete): static;

    /**
     * @param class-string<BindingAbstract> ...$aliases
     *
     * @return static
     */
    public function as(string ...$aliases): static;

    /**
     * @param \Smpl\DI\Contracts\Binding<BindingAbstract> $binding
     *
     * @return static
     */
    public function extend(Binding $binding): static;
}

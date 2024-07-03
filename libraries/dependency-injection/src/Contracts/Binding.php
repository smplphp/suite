<?php

namespace Smpl\DI\Contracts;

/**
 * @template BindingAbstract of object
 */
interface Binding
{
    /**
     * Get the abstract that is being bound
     *
     * @return class-string<BindingAbstract>
     */
    public function abstract(): string;

    /**
     * @return class-string<BindingAbstract>|object<BindingAbstract>|callable(): BindingAbstract
     */
    public function concrete(): string|object|callable;

    /**
     * Get the aliases of the binding
     *
     * @return array<class-string<BindingAbstract>>
     */
    public function aliases(): array;
}

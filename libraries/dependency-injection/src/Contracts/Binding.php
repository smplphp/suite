<?php

namespace Smpl\DI\Contracts;

/**
 * @template BindingAbstract of object
 */
interface Binding
{
    /**
     * Get the abstract the binding represents
     *
     * @return class-string<BindingAbstract>
     */
    public function abstract(): string;

    /**
     * Get the concrete the abstract is bound to
     *
     * @return class-string<BindingAbstract>|object|null
     *
     * @phpstan-return class-string<BindingAbstract>|BindingAbstract|null
     * @psalm-return class-string<BindingAbstract>|BindingAbstract|null
     */
    public function concrete(): string|object|null;

    /**
     * Get the aliases of the binding
     *
     * @return array<class-string<BindingAbstract>>
     */
    public function aliases(): array;

    /**
     * Get the factory to be used when resolving this binding
     *
     * @return callable(): BindingAbstract|null
     */
    public function factory(): ?callable;

    /**
     * Is the binding shared?
     *
     * @return bool
     */
    public function shared(): bool;
}

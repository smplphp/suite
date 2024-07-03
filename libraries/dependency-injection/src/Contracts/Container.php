<?php

namespace Smpl\DI\Contracts;

/**
 * Container
 *
 * The container is responsible for containing an applications' bindings.
 *
 * @package DependencyInjection
 */
interface Container
{
    /**
     * Register a binding with the container
     *
     * This method will register the binding with the container and map it to
     * its abstract.
     * This method will also map the binding to its aliases.
     * If the <code>$override</code> parameter is false, and a binding or alias
     * mapping already exists for the provided bindings abstract, or aliases, an
     * error will be thrown.
     *
     * @param \Smpl\DI\Contracts\Binding<object> $binding
     * @param bool                               $override
     *
     * @return static
     *
     * @throws \Smpl\DI\Exceptions\BindingAlreadyRegisteredException
     */
    public function bind(Binding $binding, bool $override = true): static;

    /**
     * Retrieve a binding from the container
     *
     * This method will return a corresponding binding the provided abstract
     * if one is present.
     * If the <code>$useAliases</code> parameter is false, this method will
     * ignore aliases.
     *
     * @template AbstractClass of object
     *
     * @param class-string<AbstractClass> $abstract
     * @param bool                        $useAliases
     *
     * @return \Smpl\DI\Contracts\Binding<AbstractClass>|null
     */
    public function binding(string $abstract, bool $useAliases = true): ?Binding;

    /**
     * Check if a binding is present in the container
     *
     * This method checks the container to see if there is a corresponding
     * binding for the provided abstract.
     * If the <code>$useAliases</code> parameter is false, this method will
     * ignore aliases.
     *
     * @param string $abstract
     * @param bool   $useAliases
     *
     * @return bool
     */
    public function bound(string $abstract, bool $useAliases = true): bool;
}

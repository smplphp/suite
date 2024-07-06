<?php

namespace Smpl\DI\Contracts;

/**
 * @template BindingAbstract of object
 */
interface BindingBuilder
{
    /**
     * Create a new binding builder for an abstract
     *
     * This method creates a new binding builder for an abstract.
     * If the provided abstract is an object, its class will be used as the
     * abstract, and the object will be used as the concrete.
     *
     * @template Abstract of object
     *
     * @param class-string<Abstract>|object           $abstract
     *
     * @return static
     *
     * @phpstan-param class-string<Abstract>|Abstract $abstract
     * @psalm-param class-string<Abstract>|Abstract   $abstract
     */
    public static function bind(string|object $abstract): static;

    /**
     * Set the concrete for the binding
     *
     * This method sets the binding concrete to be either a class or an instance.
     *
     * @param class-string<BindingAbstract>|object                  $concrete
     *
     * @return static
     *
     * @phpstan-param class-string<BindingAbstract>|BindingAbstract $concrete
     * @psalm-param class-string<BindingAbstract>|BindingAbstract   $concrete
     */
    public function to(string|object $concrete): static;

    /**
     * Alias the binding
     *
     * This method sets the aliases that the binding should also be bound as.
     * Aliases are secondary to abstracts in terms of the discovery order.
     *
     * @param class-string<BindingAbstract> ...$aliases
     *
     * @return static
     */
    public function as(string ...$aliases): static;

    /**
     * Set a factory for resolution
     *
     * This method sets the factory to be used to be when attempting to resolve
     * an instance of the bindings' abstract.
     *
     * @param callable(): BindingAbstract $factory
     *
     * @return static
     */
    public function using(callable $factory): static;

    /**
     * Mark the binding as shared
     *
     * This method marks the final binding as shared, meaning that once it has
     * been resolved, or, if the provided concrete is an instance, that same
     * instance will be used for each following request.
     *
     * @return static
     */
    public function shared(): static;

    /**
     * Build a binding
     *
     * @return \Smpl\DI\Contracts\Binding<BindingAbstract>
     */
    public function build(): Binding;
}

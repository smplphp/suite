<?php
/** @noinspection PhpUnnecessaryStaticReferenceInspection */
declare(strict_types=1);

namespace Smpl\DI\Bindings;

use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use Smpl\DI\Attributes\BindAs;
use Smpl\DI\Attributes\Factory;
use Smpl\DI\Attributes\Shared;
use Smpl\DI\Container;
use Smpl\DI\Contracts\Binding;
use Smpl\DI\Contracts\BindingBuilder;

/**
 * @template BindingAbstract of object
 *
 * @implements \Smpl\DI\Contracts\BindingBuilder<BindingAbstract>
 */
final class Builder implements BindingBuilder
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
     * @param class-string<Abstract>|object                                                         $abstract
     *
     * @return static
     *
     * @psalm-param class-string<Abstract>|Abstract                                                 $abstract
     * @phpstan-param class-string<BindingAbstract>|BindingAbstract|class-string<Abstract>|Abstract $abstract
     */
    public static function bind(object|string $abstract): static
    {
        /**
         * @psalm-var self<Abstract>          $binding
         * @phpstan-var self<BindingAbstract> $binding
         */
        $binding = new self(is_object($abstract) ? $abstract::class : $abstract);

        if (is_object($abstract)) {
            /**
             * @phpstan-var BindingAbstract $abstract
             * @psalm-var Abstract          $abstract
             */
            $binding->to($abstract);
        }

        return $binding;
    }

    /**
     * Extend a pre-existing binding
     *
     * This method extends a pre-existing binding, so that you can customise
     * a binding without having to manually redefine it every time.
     *
     * @template ExistingBindingAbstract of object
     *
     * @param \Smpl\DI\Contracts\Binding<ExistingBindingAbstract>                                                     $binding
     *
     * @return static
     *
     * @psalm-param \Smpl\DI\Contracts\Binding<ExistingBindingAbstract>                                               $binding
     * @phpstan-param \Smpl\DI\Contracts\Binding<ExistingBindingAbstract>|\Smpl\DI\Contracts\Binding<BindingAbstract> $binding
     */
    public static function extend(Binding $binding): static
    {
        /**
         * @psalm-var self<ExistingBindingAbstract>                         $builder
         * @phpstan-var self<ExistingBindingAbstract>|self<BindingAbstract> $builder
         */
        $builder = new self($binding->abstract());

        // We're intentionally not using the setters here as we don't want
        // to "reset the binding", and because some will be default values
        // that we can't set with the methods.
        $builder->concrete = $binding->concrete();
        $builder->aliases  = $binding->aliases();
        $builder->factory  = $binding->factory();
        $builder->shared   = $binding->shared();
        $builder->binding  = $binding;

        /**
         * If this isn't here, PHPStan cries.
         * @var self<BindingAbstract> $builder
         */

        return $builder;
    }

    /**
     * Create a builder from a class
     *
     * This method takes an existing class and inspects it for attributes and
     * other useful enrichment characteristics, and then builds a binding from
     * it.
     *
     * @template FromClass of object
     *
     * @param class-string<FromClass>                                       $class
     *
     * @return static|null
     *
     * @psalm-param class-string<FromClass>                                 $class
     * @phpstan-param class-string<FromClass>|class-string<BindingAbstract> $class
     */
    public static function from(string $class): ?static
    {
        try {
            $reflection = new ReflectionClass($class);

            /** @var \Smpl\DI\Attributes\BindAs<FromClass>|\Smpl\DI\Attributes\BindAs<BindingAbstract>|null $bindAs */
            $bindAs = ($reflection->getAttributes(BindAs::class)[0] ?? null)?->newInstance();

            // If the bind as attribute is present, we'll get the abstract and
            // aliases from that.
            if ($bindAs !== null) {
                $builder = new self($bindAs->abstract);
                $builder->as(...$bindAs->aliases);
            } else {
                $builder = new self($class);
            }

            /**
             * @psalm-var self<FromClass>                         $builder
             * @phpstan-var self<BindingAbstract>|self<FromClass> $builder
             */

            // Make sure we're using the provided class as the concrete.
            $builder->to($class);

            // If the shared attribute is present, it should be a shared binding.
            if (count($reflection->getAttributes(Shared::class)) === 1) {
                $builder->shared();
            }

            // Look for all public and static methods that use the factory
            // attribute.
            $factoryMethods = array_filter(
                $reflection->getMethods(ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_STATIC),
                static function (ReflectionMethod $method) {
                    return count($method->getAttributes(Factory::class)) === 1;
                }
            );

            assert(count($factoryMethods) <= 1, 'Bindings cannot have more than one factory');

            // TODO: Create a caller from the factory method

            /**
             * If this isn't here, PHPStan cries.
             * @var self<BindingAbstract> $builder
             */

            return $builder;
        } catch (ReflectionException) {
        }

        return null;
    }

    /**
     * @var class-string<BindingAbstract>
     */
    private string $abstract;

    /**
     * @var class-string<BindingAbstract>|object|null
     *
     * @psalm-var class-string<BindingAbstract>|BindingAbstract|null
     * @phpstan-var class-string<BindingAbstract>|BindingAbstract|null
     */
    private object|string|null $concrete = null;

    /**
     * @var array<class-string<BindingAbstract>>
     */
    private array $aliases = [];

    /**
     * @var callable(): BindingAbstract|null
     */
    private $factory;

    /**
     * @var bool
     */
    private bool $shared = false;

    /**
     * @var \Smpl\DI\Contracts\Binding<BindingAbstract>|null
     */
    private ?Binding $binding = null;

    /**
     * @param class-string<BindingAbstract> $abstract
     */
    public function __construct(string $abstract)
    {
        $this->abstract = $abstract;
    }

    /**
     * Reset the built binding
     *
     * @return void
     */
    private function resetBinding(): void
    {
        $this->binding = null;
    }

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
    public function to(object|string $concrete): static
    {
        $this->concrete = $concrete;

        if (is_object($concrete)) {
            $this->shared();
        }

        if (isset($this->factory)) {
            $this->factory = null;
        }

        $this->resetBinding();

        return $this;
    }

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
    public function as(string ...$aliases): static
    {
        $this->aliases = array_merge($this->aliases, $aliases);

        $this->resetBinding();

        return $this;
    }

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
    public function using(callable $factory): static
    {
        $this->factory = $factory;

        if (isset($this->concrete)) {
            $this->concrete = null;
        }

        $this->resetBinding();

        return $this;
    }

    /**
     * Mark the binding as shared
     *
     * This method marks the final binding as shared, meaning that once it has
     * been resolved, or, if the provided concrete is an instance, that same
     * instance will be used for each following request.
     *
     * @return static
     */
    public function shared(): static
    {
        $this->shared = true;

        $this->resetBinding();

        return $this;
    }

    /**
     * Build a binding
     *
     * @return \Smpl\DI\Contracts\Binding<BindingAbstract>
     */
    public function build(): Binding
    {
        // If we've already built a binding, we'll use that.
        if ($this->binding !== null) {
            return $this->binding;
        }

        // ALl bindings should have either a concrete or a factory.
        assert($this->concrete !== null || $this->factory !== null, 'Bindings require a concrete or a factory');

        // If there's a factory, we can use the specialised factory binding.
        if (isset($this->factory)) {
            $binding = $this->buildFactoryBinding();
        } else if ($this->shared) {
            // If this is a shared binding, we can use that specialised
            // implementation instead.
            $binding = $this->buildSharedBinding();
        } else {
            // The concrete should not be an object by this point.
            assert(! is_object($this->concrete), 'Bindings with object concretes should be marked as shared');

            // If we're here, it's a generic binding.
            return $this->buildGenericBinding();
        }

        return $this->binding = $binding;
    }

    /**
     * Build a specialised factory binding instance
     *
     * @return \Smpl\DI\Bindings\FactoryBinding<BindingAbstract>
     */
    private function buildFactoryBinding(): FactoryBinding
    {
        assert($this->factory !== null, 'Factory bindings must have a factory');

        return new FactoryBinding(
            $this->abstract,
            $this->factory,
            $this->aliases,
            $this->shared
        );
    }

    /**
     * Build a specialised shared binding instance
     *
     * @return \Smpl\DI\Bindings\SharedBinding<BindingAbstract>
     */
    private function buildSharedBinding(): SharedBinding
    {
        assert($this->concrete !== null, 'Non-factory bindings must have a concrete');

        return new SharedBinding(
            $this->abstract,
            $this->concrete,
            $this->aliases
        );
    }

    /**
     * Build a generic binding instance
     *
     * @return \Smpl\DI\Bindings\GenericBinding<BindingAbstract>
     */
    private function buildGenericBinding(): GenericBinding
    {
        assert(is_string($this->concrete), 'Generic bindings require a class-based concrete');

        return new GenericBinding(
            $this->abstract,
            $this->concrete,
            $this->aliases
        );
    }

    /**
     *
     */
    public function __destruct()
    {
        /**
         * The exception is never thrown because override is true
         * @noinspection PhpUnhandledExceptionInspection
         * @noinspection PhpRedundantOptionalArgumentInspection
         */
        Container::instance()->bind($this->build(), true);
    }
}

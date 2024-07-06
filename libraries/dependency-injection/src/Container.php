<?php
/**
 * @noinspection ContractViolationInspection
 * @noinspection PhpUnnecessaryStaticReferenceInspection
 */

namespace Smpl\DI;

use Smpl\Collections\Contracts\Dictionary as DictionaryContract;
use Smpl\Collections\Dictionary;
use Smpl\DI\Contracts\Binding;
use Smpl\DI\Exceptions\BindingAlreadyRegisteredException;
use Smpl\Events\Contracts\EventBus as EventBusContract;
use Smpl\Events\EventBus;

final class Container implements Contracts\Container
{
    /**
     * The current instance of the container
     *
     * @var \Smpl\DI\Container
     */
    private static self $instance;

    /**
     * Get the current instance of the container
     *
     * @return self
     */
    public static function instance(): self
    {
        if (! self::$instance instanceof self) {
            return self::setInstance(new self());
        }

        return self::$instance;
    }

    /**
     * Set the current instance of the container
     *
     * @param \Smpl\DI\Container $instance
     *
     * @return self
     */
    public static function setInstance(self $instance): self
    {
        return self::$instance = $instance;
    }

    /**
     * @var \Smpl\Collections\Contracts\Dictionary<class-string, \Smpl\DI\Contracts\Binding<object>>
     */
    private DictionaryContract $bindings;

    /**
     * @var \Smpl\Collections\Contracts\Dictionary<class-string, class-string>
     */
    private DictionaryContract $aliases;

    /**
     * @var \Smpl\Events\Contracts\EventBus
     */
    private EventBusContract $events;

    //#[NoAutowiring]

    /**
     * @param \Smpl\Collections\Contracts\Dictionary<class-string, \Smpl\DI\Contracts\Binding<object>>|null $bindings
     * @param \Smpl\Collections\Contracts\Dictionary<class-string, class-string>|null                       $aliases
     * @param \Smpl\Events\Contracts\EventBus|null                                                          $events
     */
    public function __construct(
        DictionaryContract $bindings = null,
        DictionaryContract $aliases = null,
        EventBusContract   $events = null
    )
    {
        /** @psalm-suppress MixedPropertyTypeCoercion */
        $this->bindings = $bindings ?? new Dictionary();
        /** @psalm-suppress MixedPropertyTypeCoercion */
        $this->aliases = $aliases ?? new Dictionary();
        $this->events  = $events ?? new EventBus(new EventSubscribers());
    }

    /**
     * Check if a binding is present and throw an exception
     *
     * @param \Smpl\DI\Contracts\Binding<object> $binding
     *
     * @return void
     * @throws \Smpl\DI\Exceptions\BindingAlreadyRegisteredException
     */
    private function throwIfBindingIsPresent(Binding $binding): void
    {
        if ($this->bindings->has($binding->abstract())) {
            throw BindingAlreadyRegisteredException::make($binding->abstract());
        }

        foreach ($binding->aliases() as $alias) {
            if ($this->bindings->has($alias)) {
                throw BindingAlreadyRegisteredException::make($alias, true);
            }
        }
    }

    /**
     * Get the container event bus
     *
     * @return \Smpl\Events\Contracts\EventBus
     */
    public function events(): EventBusContract
    {
        return $this->events;
    }

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
    public function bind(Binding $binding, bool $override = true): static
    {
        if ($override === false) {
            $this->throwIfBindingIsPresent($binding);
        }

        $bound = $this->bound($binding->abstract());

        if ($bound) {
            /** @noinspection UnusedFunctionResultInspection */
            $this->events()->dispatch(new Events\Rebinding($binding->abstract()));
        } else {
            /** @noinspection UnusedFunctionResultInspection */
            $this->events()->dispatch(new Events\Binding($binding->abstract()));
        }

        $this->bindings->put($binding->abstract(), $binding);

        foreach ($binding->aliases() as $alias) {
            $this->aliases->put($alias, $binding->abstract());
        }

        if ($bound) {
            /** @noinspection UnusedFunctionResultInspection */
            $this->events()->dispatch(new Events\Rebound($binding->abstract()));
        } else {
            /** @noinspection UnusedFunctionResultInspection */
            $this->events()->dispatch(new Events\Bound($binding->abstract()));
        }

        return $this;
    }

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
    public function binding(string $abstract, bool $useAliases = true): ?Binding
    {
        /** @var \Smpl\DI\Contracts\Binding<AbstractClass>|null $binding */
        $binding = $this->bindings->get($abstract);

        if ($binding === null && $useAliases === true) {
            /** @var class-string<AbstractClass>|null $alias */
            $alias = $this->aliases->get($abstract);

            if ($alias !== null) {
                /**
                 * This is here to stop static analysis crying
                 * @var \Smpl\DI\Contracts\Binding<AbstractClass>|null $trueBinding
                 */
                $trueBinding = $this->bindings->get($alias);

                return $trueBinding;
            }
        }

        if ($binding === null) {
            /** @noinspection UnusedFunctionResultInspection */
            $this->events()->dispatch(new Events\UnknownBinding($abstract));
        }

        return $binding;
    }

    /**
     * Check if a binding is present in the container
     *
     * This method checks the container to see if there is a corresponding
     * binding for the provided abstract.
     * If the <code>$useAliases</code> parameter is false, this method will
     * ignore aliases.
     *
     * @param class-string $abstract
     * @param bool         $useAliases
     *
     * @return bool
     */
    public function bound(string $abstract, bool $useAliases = true): bool
    {
        return $this->binding($abstract, $useAliases) !== null;
    }
}

<?php

namespace Smpl\Events\Contracts;

use Closure;

interface EventBus
{
    /**
     * Register a listener with the event bus
     *
     * This method will extract and register all subscriber methods present
     * in the class or instance provided.
     *
     * @param object|class-string $listener
     *
     * @return static
     */
    public function listen(object|string $listener): static;

    /**
     * Register a subscriber with the event bus
     *
     * This method will register the provided subscriber against the event
     * it subscribes to.
     *
     * @param \Closure|callable|array|string $subscriber
     *
     * @return static
     */
    public function subscribe(Closure|callable|array|string $subscriber): static;

    /**
     * Dispatch an event on the event bus
     *
     * This method takes an event and dispatches it to any registered subscribers
     * it has.
     *
     * @template EventClass of object
     *
     * @param object<EventClass> $event
     *
     * @return object<EventClass>
     */
    public function dispatch(object $event): object;
}

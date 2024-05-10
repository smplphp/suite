<?php

namespace Smpl\Events\Contracts;

/**
 * Event Bus
 *
 * An event bus is used to register listeners and dispatch events to those
 * listeners.
 *
 * @package Events
 */
interface Bus
{
    /**
     * Register listeners with the event bus
     *
     * This method will register all listeners present in the provided class or
     * instance.
     *
     * @param object|string $listener
     *
     * @return static
     */
    public function register(object|string $listener): static;

    /**
     * Deregister listeners with the event bus
     *
     * This method will deregister all listeners present in the provided class or
     * instance.
     *
     * @param object|string $listener
     *
     * @return static
     */
    public function deregister(object|string $listener): static;

    /**
     * Dispatch an event to its listeners
     *
     * This method dispatches the provided event to its listeners if there are
     * any.
     * If there are no registered listeners a {@see \Smpl\Events\DeadEvent} is
     * dispatched instead, if the event does not have the
     * {@see \Smpl\Events\Attributes\Undead} attribute.
     *
     * @template EventObject of object
     *
     * @param object              $event
     *
     * @return object
     *
     * @psalm-param EventObject   $event
     * @phpstan-param EventObject $event
     *
     * @psalm-return EventObject
     * @phpstan-return EventObject
     */
    public function dispatch(object $event): object;
}

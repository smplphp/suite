<?php

namespace Smpl\Events\Contracts;

use Closure;
use ReflectionFunction;
use ReflectionMethod;
use Smpl\Collections\Contracts\Set;

interface SubscriberRegistry
{
    /**
     * Register a subscriber against an event
     *
     * @template EventClass of object
     *
     * @param class-string<EventClass>              $event
     * @param \Closure(EventClass): mixed           $subscriber
     * @param \ReflectionFunction|\ReflectionMethod $reflection
     *
     * @return static
     */
    public function register(string $event, Closure $subscriber, ReflectionFunction|ReflectionMethod $reflection): static;

    /**
     * Get all subscribers for an event
     *
     * @template EventClass of object
     *
     * @param object<EventClass> $event
     *
     * @return \Smpl\Collections\Contracts\Set<\Closure(EventClass): mixed>
     */
    public function subscribers(object $event): Set;
}

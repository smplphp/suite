<?php
/** @noinspection PhpUnnecessaryStaticReferenceInspection */

namespace Smpl\Events;

use Closure;
use ReflectionFunction;
use ReflectionMethod;
use Smpl\Collections\Contracts\Set as SetContract;
use Smpl\Collections\Set;

final class Subscribers implements Contracts\SubscriberRegistry
{
    /**
     * @var array<class-string, array<\Closure(object): mixed>>
     */
    private array $subscribers = [];

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
    public function register(string $event, Closure $subscriber, ReflectionFunction|ReflectionMethod $reflection): static
    {
        if (isset($this->subscribers[$event]) && in_array($subscriber, $this->subscribers[$event], true)) {
            // Silently fail, it's already registered. If someone wants it to
            // complain, they can write a custom subscriber registry.
            return $this;
        }

        /**
         * PHPStan cannot figure out that EventClass is an object, so we need this.
         * @var Closure(object): mixed $subscriber
         */

        /** @psalm-suppress InvalidPropertyAssignmentValue */
        $this->subscribers[$event][] = $subscriber;

        return $this;
    }

    /**
     * Get all subscribers for an event
     *
     * @template EventClass of object
     *
     * @param object             $event
     *
     * @return \Smpl\Collections\Contracts\Set<\Closure(EventClass): mixed>
     *
     * @phpstan-param EventClass $event
     * @psalm-param EventClass   $event
     */
    public function subscribers(object $event): SetContract
    {
        $classes = $this->getEventHierarchy($event::class);
        /** @var \Smpl\Collections\Set<Closure(EventClass): mixed> $subscribers */
        $subscribers = new Set();

        foreach ($classes as $class) {
            if (isset($this->subscribers[$class])) {
                $subscribers->addAll($this->subscribers[$class]);
            }
        }

        return $subscribers;
    }

    /**
     * Get the class hierarchy for an event class
     *
     * @param class-string $class
     *
     * @return class-string[]
     */
    private function getEventHierarchy(string $class): array
    {
        return [$class] + class_parents($class) + class_implements($class);
    }
}

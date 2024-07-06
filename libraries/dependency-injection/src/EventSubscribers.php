<?php
/** @noinspection PhpUnnecessaryStaticReferenceInspection */

namespace Smpl\DI;

use Closure;
use ReflectionFunction;
use ReflectionMethod;
use Smpl\Collections\Contracts\Set as SetContract;
use Smpl\Collections\Set;
use Smpl\DI\Attributes\ForAbstract;
use Smpl\Events\Contracts;

final class EventSubscribers implements Contracts\SubscriberRegistry
{
    /**
     * @var array<class-string, array<\Closure(object): mixed>>
     */
    private array $globalSubscribers = [];

    /**
     * @var array<class-string, array<class-string, array<Closure(object): mixed>>>
     */
    private array $exactSubscribers = [];

    /**
     * @var array<class-string, array<class-string, array<Closure(object): mixed>>>
     */
    private array $instanceOfSubscribers = [];

    /**
     * Register a subscriber against an event
     *
     * @template EventClass of \Smpl\DI\Events\BaseAbstractEvent
     *
     * @param class-string<EventClass>              $event
     * @param \Closure(EventClass): mixed           $subscriber
     * @param \ReflectionFunction|\ReflectionMethod $reflection
     *
     * @return static
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function register(string $event, Closure $subscriber, ReflectionFunction|ReflectionMethod $reflection): static
    {
        /** @var \Smpl\DI\Attributes\ForAbstract|null $forAbstract */
        $forAbstract = ($reflection->getAttributes(ForAbstract::class)[0] ?? null)?->newInstance();

        // If the for abstract attribute is present, we're only listening to events
        // for a particular class.
        if ($forAbstract !== null) {
            // Sometimes we'll be listening for an exact match, and sometimes
            // we're listening for anything that is a descendant of a particular
            // class.
            /** @psalm-suppress UnsupportedPropertyReferenceUsage */
            if ($forAbstract->exact) {
                $subscribers = &$this->exactSubscribers;
            } else {
                $subscribers = &$this->instanceOfSubscribers;
            }

            // If the subscriber is already registered, we'll return silently.
            if (isset($subscribers[$event][$forAbstract->abstract]) && in_array($subscriber, $subscribers[$event][$forAbstract->abstract], true)) {
                return $this;
            }

            $subscribers[$event][$forAbstract->abstract][] = $subscriber;
        } else {
            if (isset($this->globalSubscribers[$event]) && in_array($subscriber, $this->globalSubscribers[$event], true)) {
                // Silently fail if it's already registered. If someone wants it to
                // complain, they can write a custom subscriber registry.
                return $this;
            }

            /**
             * @psalm-suppress PropertyTypeCoercion
             * @var \Closure(object): mixed $subscriber
             */
            $this->globalSubscribers[$event][] = $subscriber;
        }

        return $this;
    }

    /**
     * Get all subscribers for an event
     *
     * @template EventClass of \Smpl\DI\Events\BaseAbstractEvent
     *
     * @param object             $event
     *
     * @return \Smpl\Collections\Contracts\Set<\Closure(EventClass): mixed>
     *
     * @phpstan-param EventClass $event
     * @psalm-param EventClass   $event
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function subscribers(object $event): SetContract
    {
        $classes = $this->getClassHierarchy($event::class);
        /** @var \Smpl\Collections\Set<Closure(EventClass): mixed> $subscribers */
        $subscribers = new Set();

        foreach ($classes as $class) {
            // First get all the global subscribers
            if (isset($this->globalSubscribers[$class])) {
                $subscribers->addAll($this->globalSubscribers[$class]);
            }

            // Then any that are only subscribing to events for this exact class
            if (isset($this->exactSubscribers[$class][$event->abstract])) {
                $subscribers->addAll($this->exactSubscribers[$class][$event->abstract]);
            }

            // Then any that are subscribing to events for an instance of the class
            if (isset($this->instanceOfSubscribers[$class])) {
                foreach ($this->getClassHierarchy($event->abstract) as $abstractClass) {
                    if (isset($this->instanceOfSubscribers[$class][$abstractClass])) {
                        $subscribers->addAll($this->instanceOfSubscribers[$class][$abstractClass]);
                    }
                }
            }
        }

        return $subscribers;
    }

    /**
     * Get the hierarchy of a class
     *
     * @param class-string $class
     *
     * @return class-string[]
     */
    private function getClassHierarchy(string $class): array
    {
        return [$class] + class_parents($class) + class_implements($class);
    }
}

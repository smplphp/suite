<?php
/** @noinspection PhpUnnecessaryStaticReferenceInspection */

namespace Smpl\Events;

use Closure;
use ReflectionClass;
use ReflectionFunction;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionObject;
use RuntimeException;
use Smpl\Events\Attributes\Subscribes;
use Smpl\Events\Attributes\Undead;
use Smpl\Events\Contracts\SubscriberRegistry;

final class EventBus implements Contracts\EventBus
{
    /**
     * @var \Smpl\Events\Contracts\SubscriberRegistry
     */
    private SubscriberRegistry $subscribers;

    public function __construct(SubscriberRegistry $subscribers = null)
    {
        $this->subscribers = $subscribers ?? new Subscribers();
    }

    /**
     * Register a listener with the event bus
     *
     * This method will extract and register all subscriber methods present
     * in the class or instance provided.
     *
     * @param object|class-string $listener
     *
     * @return static
     *
     * @throws \ReflectionException
     */
    public function listen(object|string $listener): static
    {
        $reflection   = new ReflectionClass($listener);
        $methodFilter = ReflectionMethod::IS_PUBLIC;

        if (is_string($listener)) {
            $methodFilter |= ReflectionMethod::IS_STATIC;
        }

        $methods = array_filter(
            $reflection->getMethods($methodFilter),
            static function (ReflectionMethod $method) {
                return count($method->getAttributes(Subscribes::class)) === 1;
            }
        );

        foreach ($methods as $method) {
            $this->subscribeReflection([$listener, $method->getName()], $method);
        }

        return $this;
    }

    /**
     * Register a subscriber with the event bus
     *
     * This method will register the provided subscriber against the event
     * it subscribes to.
     *
     * @param \Closure|callable|array|string $subscriber
     *
     * @return static
     *
     * @throws \ReflectionException
     */
    public function subscribe(callable|array|Closure|string $subscriber): static
    {
        if (is_string($subscriber)) {
            $this->subscribeString($subscriber);
        } else if (is_object($subscriber)) {
            if ($subscriber instanceof Closure) {
                $this->subscribeClosure($subscriber);
            } else if (is_callable($subscriber)) {
                $this->subscribeInvokable($subscriber);
            }
        } else if (is_array($subscriber)) {
            $this->subscribeArray($subscriber);
        }

        return $this;
    }

    /**
     * Subscribe a string
     *
     * This method will allow for the subscription of static method references
     * as strings, as well as functions by name.
     *
     * @param string $subscriber
     *
     * @return void
     *
     * @throws \ReflectionException
     */
    private function subscribeString(string $subscriber): void
    {
        if (str_contains($subscriber, '::')) {
            $this->subscribeArray(explode('::', $subscriber));
        } else if (function_exists($subscriber)) {
            $this->subscribeReflection($subscriber, new ReflectionFunction($subscriber));
        }

        // TODO: Better exception
        throw new RuntimeException('Invalid string subscriber');
    }

    /**
     * Subscribe a Closure
     *
     * This method subscribes a closure.
     *
     * @param \Closure $subscriber
     *
     * @return void
     * @throws \ReflectionException
     */
    private function subscribeClosure(Closure $subscriber): void
    {
        $this->subscribeReflection($subscriber, new ReflectionFunction($subscriber));
    }

    /**
     * Subscribe an invokable
     *
     * This method takes an instance of a class with an __invoke method, and
     * subscribes it.
     * It is important that this method be called after a check for an instance
     * of {@see \Closure}, as that is considered invokable.
     *
     * @param object $subscriber
     *
     * @return void
     *
     * @throws \ReflectionException
     */
    private function subscribeInvokable(object $subscriber): void
    {
        if (! is_callable($subscriber)) {
            // TODO: Better exception
            throw new RuntimeException('Invalid object subscriber');
        }

        $reflection = new ReflectionObject($subscriber);

        if (! $reflection->hasMethod('__invoke')) {
            // TODO: Better exception
            throw new RuntimeException('Invalid object subscriber');
        }

        $this->subscribeClosure($subscriber(...));
    }

    /**
     * Subscribe an array
     *
     * This method takes an array of instance or class, and a corresponding
     * method name.
     *
     * @param array $subscriber
     *
     * @return void
     * @throws \ReflectionException
     */
    private function subscribeArray(array $subscriber): void
    {
        if (count($subscriber) !== 2) {
            // TODO: Better exception
            throw new RuntimeException('Invalid array subscriber');
        }

        [$scope, $method] = $subscriber;

        $reflection = new ReflectionClass($scope);

        if (! $reflection->hasMethod($method)) {
            // TODO: Better exception
            throw new RuntimeException('Invalid array subscriber');
        }

        $methodReflection = $reflection->getMethod($method);

        if (is_object($scope) && $methodReflection->isStatic()) {
            // TODO: Better exception
            throw new RuntimeException('Invalid array subscriber');
        }

        $this->subscribeReflection($subscriber, $methodReflection);
    }

    /**
     * Register a subscriber using reflection
     *
     * @param callable|array|\Closure|string        $subscriber
     * @param \ReflectionMethod|\ReflectionFunction $reflection
     *
     * @return void
     */
    protected function subscribeReflection(callable|array|Closure|string $subscriber, ReflectionMethod|ReflectionFunction $reflection): void
    {
        if ($reflection->getNumberOfParameters() === 0) {
            // TODO: Better exception
            throw new RuntimeException('Subscriber is invalid');
        }

        $eventType = $reflection->getParameters()[0]->getType();

        if (! ($eventType instanceof ReflectionNamedType) || $eventType->isBuiltin()) {
            // TODO: Better exception
            throw new RuntimeException('Subscriber is invalid');
        }

        $this->subscribers->register(
            $eventType,
            $subscriber instanceof Closure ? $subscriber : $subscriber(...),
            $reflection
        );
    }

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
    public function dispatch(object $event): object
    {
        $subscribers = $this->subscribers->subscribers($event);

        if ($subscribers->isEmpty()) {
            $this->deadEvent($event);

            return $event;
        }

        foreach ($subscribers as $subscriber) {
            $subscriber($event);
        }
    }

    /**
     * Handle an event without subscribers
     *
     * This method takes an event without subscribers, and if it isn't marked
     * as undead, dispatches a {@see \Smpl\Events\DeadEvent} to the event bus.
     *
     * @template EventClass of object
     *
     * @param object<EventClass> $event
     *
     * @return void
     */
    protected function deadEvent(object $event): void
    {
        if ($this->isEventUndead($event)) {
            return;
        }

        $this->dispatch(new DeadEvent($event));
    }

    /**
     * Check if an event is marked as undead
     *
     * @param object $event
     *
     * @return bool
     */
    protected function isEventUndead(object $event): bool
    {
        return $event instanceof DeadEvent || ! empty((new ReflectionClass($event))->getAttributes(Undead::class));
    }
}

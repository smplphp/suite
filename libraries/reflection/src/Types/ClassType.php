<?php

namespace Smpl\Reflection\Types;

use Smpl\Reflection\Contracts\Type;
use Traversable;

/**
 * @template TypeClass of object
 */
final class ClassType implements Type
{
    /**
     * @var class-string<TypeClass>
     */
    private string $class;

    /**
     * @param class-string<TypeClass> $class
     *
     * @internal
     */
    public function __construct(string $class)
    {
        $this->class = $class;
    }

    /**
     * @return class-string<TypeClass>
     */
    public function name(): string
    {
        return $this->class;
    }

    /**
     * @param \Smpl\Reflection\Contracts\Type $type
     *
     * @return bool
     */
    public function assignableTo(Type $type): bool
    {
        // Are we dealing with a class?
        if (class_exists($type->name())) {
            // Are the types the same or an ancestor?
            /** @psalm-suppress ArgumentTypeCoercion */
            return is_a($this->name(), $type->name(), true);
        }

        // Is the provided type an iterable, and we're traversable?
        if (BuiltInTypes::Iterable->is($type)) {
            /** @psalm-suppress TypeDoesNotContainType */
            return is_subclass_of($this->name(), Traversable::class);
        }

        /** @psalm-suppress ArgumentTypeCoercion */
        // Finally, is it being assigned to an object or mixed?
        return BuiltInTypes::Object->is($type) || BuiltInTypes::Mixed->is($type);
    }

    public function assignableFrom(Type $type): bool
    {
        // Are the types the same or a descendant?
        /** @psalm-suppress ArgumentTypeCoercion */
        return is_a($type->name(), $this->name(), true);
    }

    public function is(Type $type): bool
    {
        return $this->name() === $type->name();
    }

    public function matches(mixed $value): bool
    {
        return $value instanceof $this->class;
    }
}

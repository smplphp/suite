<?php

namespace Smpl\Reflection\Types;

use ReflectionNamedType;
use Smpl\Reflection\Contracts\Type;
use Traversable;

enum BuiltInTypes: string implements Type
{
    case String = 'string';

    case Float = 'float';

    case Integer = 'integer';

    case Boolean = 'boolean';

    case Array = 'array';

    case Object = 'object';

    case Resource = 'resource';

    case Iterable = 'iterable';

    case Mixed = 'mixed';

    public function name(): string
    {
        return $this->value;
    }

    public function assignableTo(Type $type): bool
    {
        if ($this->is($type)) {
            return true;
        }

        if ($this === self::Integer) {
            return self::Float->is($type);
        }

        if ($this === self::Array) {
            return self::Iterable->is($type);
        }

        return false;
    }

    public function assignableFrom(Type $type): bool
    {
        if ($this === self::Mixed || $this->is($type)) {
            return true;
        }

        if ($this === self::Float) {
            return self::Integer->is($type);
        }

        if ($this === self::Iterable) {
            return self::Array->is($type) || is_subclass_of($type->name(), Traversable::class);
        }

        if ($this === self::Object) {
            return class_exists($type->name());
        }

        return false;
    }

    public function is(Type $type): bool
    {
        return $this === $type || $this->name() === $type->name();
    }

    public function matches(mixed $value): bool
    {
        return match ($this) {
            self::String   => is_string($value),
            self::Float    => is_float($value),
            self::Integer  => is_int($value),
            self::Boolean  => is_bool($value),
            self::Array    => is_array($value),
            self::Object   => is_object($value),
            self::Resource => is_resource($value),
            self::Iterable => is_iterable($value),
            self::Mixed    => is_scalar($value),
        };
    }

    public static function includes(Type $type): bool
    {
        foreach (self::cases() as $builtInType) {
            if ($builtInType->is($type)) {
                return true;
            }
        }

        return false;
    }
}

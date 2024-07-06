<?php

namespace Smpl\Reflection;

use InvalidArgumentException;
use ReflectionIntersectionType;
use ReflectionNamedType;
use ReflectionType;
use ReflectionUnionType;
use Smpl\Reflection\Contracts\Type;
use Smpl\Reflection\Types\BuiltInTypes;
use Smpl\Reflection\Types\ClassType;
use Smpl\Reflection\Types\IntersectionType;
use Smpl\Reflection\Types\UnionType;

final class Types
{
    /**
     * @var array<string, \Smpl\Reflection\Contracts\Type>
     */
    private static array $types = [];

    /**
     * Get a type by its name
     *
     * @param string $name
     *
     * @return \Smpl\Reflection\Contracts\Type|null
     */
    public static function get(string $name): ?Type
    {
        $type = BuiltInTypes::tryFrom($name);

        return $type ?? self::$types[$name] ?? self::buildType($name);
    }

    /**
     * Get a type for a reflection type
     *
     * @param \ReflectionType $reflection
     *
     * @return \Smpl\Reflection\Contracts\Type|null
     */
    public static function getFor(ReflectionType $reflection): ?Type
    {
        if ($reflection instanceof ReflectionNamedType) {
            return self::get($reflection->getName());
        }

        if ($reflection instanceof ReflectionUnionType) {
            /**
             * This is here, so static analysis stops crying
             * @var list<\Smpl\Reflection\Contracts\Type> $types
             */
            $types = array_filter(array_map(static fn (ReflectionType $r) => self::getFor($r), $reflection->getTypes()));

            return new UnionType(
                $types,
                (string)$reflection
            );
        }

        if ($reflection instanceof ReflectionIntersectionType) {
            /**
             * This is here, so static analysis stops crying
             * @var list<\Smpl\Reflection\Contracts\Type> $types
             */
            $types = array_filter(array_map(static fn (ReflectionType $r) => self::getFor($r), $reflection->getTypes()));

            return new IntersectionType(
                $types,
                (string)$reflection
            );
        }

        throw new InvalidArgumentException('Provided reflected type isn\'t valid');
    }

    /**
     * Get a type from a value
     *
     * @param mixed $value
     *
     * @return \Smpl\Reflection\Contracts\Type|null
     */
    public static function getFrom(mixed $value): ?Type
    {
        $name = get_debug_type($value);

        if (str_starts_with($name, 'resource ')) {
            $name = 'resource';
        }

        return self::get($name);
    }

    private static function buildType(string $name): Type
    {
        if (! class_exists($name)) {
            throw new InvalidArgumentException(sprintf('Class [%s] does not exist.', $name));
        }

        return self::$types[$name] = new ClassType($name);
    }
}

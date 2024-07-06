<?php

namespace Smpl\Reflection\Types;

use Smpl\Reflection\Contracts\CompositeType;
use Smpl\Reflection\Contracts\Type;

final class UnionType implements CompositeType
{
    /**
     * @var list<\Smpl\Reflection\Contracts\Type>
     */
    private array $types;

    private string $name;

    /**
     * @param list<\Smpl\Reflection\Contracts\Type> $types
     */
    public function __construct(array $types, string $name)
    {
        $this->types = $types;
        $this->name  = $name;
    }

    /**
     * @return list<\Smpl\Reflection\Contracts\Type>
     */
    public function types(): array
    {
        return $this->types;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function assignableTo(Type $type): bool
    {
        if ($type instanceof CompositeType) {
            if ($type instanceof self) {
                foreach ($type->types() as $subType) {
                    if ($this->assignableTo($subType)) {
                        return true;
                    }
                }
            } else if ($type instanceof IntersectionType) {
                foreach ($this->types() as $subType) {
                    if (! $type->assignableFrom($subType)) {
                        return false;
                    }
                }

                return true;
            }

            return false;
        }

        foreach ($this->types() as $subType) {
            if ($subType->assignableTo($type)) {
                return true;
            }
        }

        return false;
    }

    public function assignableFrom(Type $type): bool
    {
        if ($type instanceof CompositeType) {
            if ($type instanceof self) {
                foreach ($type->types() as $subType) {
                    if ($this->assignableFrom($subType)) {
                        return true;
                    }
                }
            } else if ($type instanceof IntersectionType) {
                foreach ($this->types() as $subType) {
                    if (! $subType->assignableFrom($type)) {
                        return false;
                    }
                }

                return true;
            }

            return false;
        }

        foreach ($this->types as $subType) {
            if ($subType->assignableFrom($type)) {
                return true;
            }
        }

        return false;
    }

    public function is(Type $type): bool
    {
        return $this->name() === $type->name();
    }

    public function matches(mixed $value): bool
    {
        foreach ($this->types() as $subType) {
            if ($subType->matches($value)) {
                return true;
            }
        }

        return false;
    }
}

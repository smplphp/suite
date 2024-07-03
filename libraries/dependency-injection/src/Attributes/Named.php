<?php

namespace Smpl\DI\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PARAMETER | Attribute::TARGET_PROPERTY)]
final class Named
{
    public readonly string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}

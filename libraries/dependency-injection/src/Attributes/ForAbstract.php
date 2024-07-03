<?php

namespace Smpl\DI\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_FUNCTION)]
final readonly class ForAbstract
{
    public string $abstract;

    public bool  $exact;

    public function __construct(string $abstract, bool $exact = true)
    {
        $this->abstract = $abstract;
        $this->exact    = $exact;
    }
}

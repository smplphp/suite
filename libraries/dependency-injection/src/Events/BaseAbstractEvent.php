<?php

namespace Smpl\DI\Events;

/**
 * @template AbstractClass of object
 */
abstract readonly class BaseAbstractEvent
{
    /**
     * @var class-string<AbstractClass>
     */
    public string $abstract;

    /**
     * @param class-string<AbstractClass> $abstract
     */
    public function __construct(string $abstract)
    {
        $this->abstract = $abstract;
    }
}

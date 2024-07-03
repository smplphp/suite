<?php

namespace Smpl\DI\Contracts;

/**
 * @template ResolvedType of mixed
 */
interface Resolver
{
    /**
     * @return ResolvedType
     */
    public function resolve(): mixed;
}

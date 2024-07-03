<?php

namespace Smpl\DI\Contracts;

/**
 * @template ResolvedType of mixed
 * @template QualifierClass of object
 */
interface QualifiedResolver
{
    /**
     * @param object<QualifierClass> $qualifier
     *
     * @return ResolvedType
     */
    public function resolve(object $qualifier): mixed;
}

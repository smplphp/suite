<?php

namespace Smpl\Reflection\Contracts;

interface CompositeType extends Type
{
    /**
     * @return list<\Smpl\Reflection\Contracts\Type>
     */
    public function types(): array;
}

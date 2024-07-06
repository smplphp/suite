<?php

namespace Smpl\DI\Contracts;

use Smpl\Logic\Contracts\Supplier;

/**
 * Provider
 *
 * Providers are classes that are responsible for the resolution and
 * providing of a particular class.
 * Providers will always take precedence over bindings.
 *
 * @template ProvidedClass of object
 *
 * @extends \Smpl\Logic\Contracts\Supplier<ProvidedClass>
 */
interface Provider extends Supplier
{
    /**
     * The class that the provider provides
     *
     * @return class-string<ProvidedClass>
     */
    public function provides(): string;
}

<?php

namespace Smpl\DI\Contracts;

use Smpl\Logic\Contracts\Supplier;

/**
 * @template ProviderAbstract of object
 * @extends \Smpl\Logic\Contracts\Supplier<ProviderAbstract>
 */
interface Provider extends Supplier
{
}

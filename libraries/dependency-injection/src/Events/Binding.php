<?php

namespace Smpl\DI\Events;

use Smpl\Events\Attributes\Undead;

/**
 * @template AbstractClass of object
 *
 * @extends \Smpl\DI\Events\BaseAbstractEvent<AbstractClass>
 */
#[Undead]
final readonly class Binding extends BaseAbstractEvent
{
}

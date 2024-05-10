<?php
declare(strict_types=1);

namespace Smpl\Events\Attributes;

use Attribute;

/**
 * Undead Attribute
 *
 * The undead attribute should be added to events that should not dispatch a
 * {@see \Smpl\Events\DeadEvent} if they have no listeners.
 */
#[Attribute(Attribute::TARGET_CLASS)]
final class Undead
{

}

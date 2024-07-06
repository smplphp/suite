<?php

namespace Smpl\Events\Attributes;

use Attribute;

/**
 * Subscribes Attribute
 *
 * This attribute marks a method as being an event subscriber.
 * Event subscribers are public methods that accept a single argument that is the
 * event.
 *
 * <code>
 *     #[Subscribes]
 *     public static function onCreated(Created $event): void
 *     {}
 * </code>
 */
#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_FUNCTION)]
final class Subscribes
{

}

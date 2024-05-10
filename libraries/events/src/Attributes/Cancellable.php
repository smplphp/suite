<?php
declare(strict_types=1);

namespace Smpl\Events\Attributes;

use Attribute;

/**
 * Cancellable Attribute
 *
 * The cancellable attribute should be added to events that can be cancelled.
 */
#[Attribute(Attribute::TARGET_CLASS)]
final class Cancellable
{

}

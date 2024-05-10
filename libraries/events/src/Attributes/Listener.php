<?php
declare(strict_types=1);

namespace Smpl\Events\Attributes;

use Attribute;

/**
 * Listeners Attribute
 *
 * The listener attribute should be added to methods that should be registered
 * as event listeners.
 */
#[Attribute(Attribute::TARGET_METHOD)]
final class Listener
{

}

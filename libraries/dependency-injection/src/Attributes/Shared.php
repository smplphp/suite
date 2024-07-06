<?php
declare(strict_types=1);

namespace Smpl\DI\Attributes;

use Attribute;

/**
 * Shared Attribute
 *
 * This attribute marks a class as being shared, meaning that once it has been
 * resolved, the result will be reused, rather than recreated.
 */
#[Attribute(Attribute::TARGET_CLASS)]
final class Shared
{

}

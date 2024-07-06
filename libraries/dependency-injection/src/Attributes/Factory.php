<?php
declare(strict_types=1);

namespace Smpl\DI\Attributes;

use Attribute;

/**
 * Factory Attribute
 *
 * This attribute marks a method as a factory, either for the class that it
 * belongs to, or another.
 */
#[Attribute(Attribute::TARGET_METHOD)]
final class Factory
{

}

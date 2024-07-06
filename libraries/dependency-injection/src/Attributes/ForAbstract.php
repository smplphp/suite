<?php

namespace Smpl\DI\Attributes;

use Attribute;

/**
 * For Abstract Attribute
 *
 * This attribute should be used on event subscribers that only want to
 * subscribe to container events for specific classes.
 *
 * Below is an example, where a subscriber method is listening to the
 * <code>Rebound</code> event, but only when it's for <code>Container</code>.
 *
 * <code>
 *     #[ForAbstract(Container::class)]
 *     public static function whenContainerIsRebound(Rebound $event): void
 *     {}
 * </code>
 */
#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_FUNCTION)]
final readonly class ForAbstract
{
    public string $abstract;

    public bool  $exact;

    public function __construct(string $abstract, bool $exact = true)
    {
        $this->abstract = $abstract;
        $this->exact    = $exact;
    }
}

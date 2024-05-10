<?php
declare(strict_types=1);

namespace Smpl\Events;

use Smpl\Events\Attributes\Undead;

/**
 * Dead Event
 *
 * A dead event is dispatched on an event bus when there are no listeners for
 * a dispatched event.
 * The dead event itself is an exception, and will not itself cause the
 * dispatching of a dead event.
 *
 * @template EventClass of object
 */
#[Undead]
final readonly class DeadEvent
{
    /**
     * The event that had no listeners
     *
     * @var object
     *
     * @psalm-var EventClass
     * @phpstan-var EventClass
     */
    public object $event;

    /**
     * Create a new instance of the dead event
     *
     * @param object             $event
     *
     * @psalm-param EventClass   $event
     * @phpstan-param EventClass $event
     */
    public function __construct(object $event)
    {
        $this->event = $event;
    }
}

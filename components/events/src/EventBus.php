<?php
declare(strict_types=1);

namespace Smpl\Events;

use Override;
use Smpl\Events\Attributes\Listener;
use Smpl\Events\Contracts\Bus;

final class EventBus implements Bus
{
    #[Override]
    public function register(object|string $listener): static
    {
        $listeners = Inspector::methods()
                              ->isPublic()
                              ->paramCount(1)
                              ->paramIsObject()
                              ->hasAttribute(Listener::class)
                              ->in($listener);

        if ($listeners->hasResults()) {
            foreach ($listeners as $listener) {

            }
        }
    }

    #[Override]
    public function deregister(object|string $listener): static
    {
        // TODO: Implement deregister() method.
    }

    #[Override]
    public function dispatch(object $event): object
    {
        // TODO: Implement dispatch() method.
    }
}

<?php

declare(strict_types=1);

namespace App\Infrastructure\Event;

use App\Domain\Event\EventDispatcherInterface;

final class SimpleEventDispatcher implements EventDispatcherInterface
{
    public function dispatch(object $event): void
    {
        // TODO: Implement dispatch() method.
    }
}

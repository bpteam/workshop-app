<?php

namespace AppName\Domain\Event;

use AppName\Domain\Event\EventInterface;

interface EventDispatcherInterface
{
    public function dispatch(EventInterface $event): void;
}
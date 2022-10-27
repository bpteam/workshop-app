<?php

namespace AppName\Domain\Event;

use Monolog\DateTimeImmutable;

interface EventInterface
{
    public function getEventName(): string;
    public function getEventId(): string;
    public function getEventDateCreated(): DateTimeImmutable;
}
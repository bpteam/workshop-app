<?php

namespace AppName\Domain\Event;

use Monolog\DateTimeImmutable;

final class NewMessage implements EventInterface
{
    public const NAME = 'demo_app.message.new';
    private string $eventId;
    private DateTimeImmutable $eventDateCreated;

    public function __construct(
        public readonly string $id,
    ) {
        $this->eventId = uniqid();
        $this->eventDateCreated = new DateTimeImmutable();
    }

    public function getEventName(): string
    {
        return self::NAME;
    }

    public function getEventId(): string
    {
        return $this->eventId;
    }

    public function getEventDateCreated(): DateTimeImmutable
    {
        return $this->eventDateCreated;
    }
}
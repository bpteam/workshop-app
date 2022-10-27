<?php

namespace AppName\Infrastructure\Event;

use AppName\Domain\Event\EventDispatcherInterface;
use AppName\Domain\Event\EventInterface;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use const AMQP_NOPARAM;

class EventDispatcherMessenger implements EventDispatcherInterface
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function dispatch(EventInterface $event): void
    {
            $amqpStamp = new AmqpStamp(
                $event->getEventName(),
                AMQP_NOPARAM,
                [
                    'headers' => [
                        'name' => $event->getEventName(),
                        'id' => $event->getEventId(),
                        'date' => $event->getEventDateCreated()->format(\DateTimeInterface::RFC3339),
                    ],
                ]
            );
            $this->bus->dispatch(new Envelope($event, [$amqpStamp]));
    }
}
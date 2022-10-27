<?php

namespace AppName\Domain\UseCase;

use AppName\Domain\Entity\Message;
use AppName\Domain\Event\EventDispatcherInterface;
use AppName\Domain\Event\NewMessage;
use AppName\Domain\Repository\MessageRepositoryInterface;
use Symfony\Component\Uid\Ulid;

class MessageUseCase
{
    public function __construct(
        private readonly MessageRepositoryInterface $messageRepository,
        private readonly EventDispatcherInterface $eventDispatcher,
    ) {}

    public function findById(Ulid $id): ?Message
    {
        return $this->messageRepository->findById($id);
    }

    public function createMessage(string $text): Message
    {
        $message = new Message($text);
        $message = $this->messageRepository->save($message);

        $this->eventDispatcher->dispatch(new NewMessage(
            (string) $message->getId(),
        ));

        return $message;
    }

    public function updateMessage(Ulid $id, string $text): ?Message
    {
        $message = $this->messageRepository->findById($id);
        if (empty($message)) {
            throw new \InvalidArgumentException('Message not exists');
        }
        $message->setMessage($text);
        $message->setDateUpdateAt(new \DateTimeImmutable());
        $this->messageRepository->save($message);

        return $message;
    }
}
<?php

namespace AppName\Domain\UseCase;

use AppName\Domain\Repository\MessageRepositoryInterface;
use Symfony\Component\Uid\Ulid;

class NotificationUseCase
{
    public function __construct(
        private readonly MessageRepositoryInterface $messageRepository,
    ) {}

    public function newMessageNotification(Ulid $idMessage): void
    {
        $message = $this->messageRepository->findById($idMessage);

        if ($message === null) {
            return;
        }

        echo 'New message ' . $message->getId();
        echo $message->getMessage();
    }

    public function updatedMessageNotification(Ulid $idMessage): void
    {
        $message = $this->messageRepository->findById($idMessage);

        if ($message === null) {
            return;
        }

        echo 'Message updated ' . $message?->getId();
        echo $message->getDateUpdatedAt()->format(\DateTimeInterface::RFC3339);
    }
}
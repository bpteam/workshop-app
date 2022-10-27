<?php

namespace AppName\Domain\Repository;

use AppName\Domain\Entity\Message;
use AppName\Domain\Entity\MessageCollection;
use Symfony\Component\Uid\Ulid;

interface MessageRepositoryInterface
{
    public function findById(Ulid $id): ?Message;
    public function findAfter(\DateTimeImmutable $dateTime, string $newCursor = null): MessageCollection;
    public function save(Message $entity): Message;
}

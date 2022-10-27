<?php

namespace AppName\Domain\Entity;

use AppName\Domain\Enum\MessageType;
use AppName\Infrastructure\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Ulid;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
#[ORM\Table(name: '`message_demo`')]
class Message
{
    #[ORM\Id]
    #[ORM\Column(type: 'ulid')]
    private Ulid $id;

    #[ORM\Column(type: 'string')]
    private string $message;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $dateCreatedAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $dateUpdateAt;

    #[ORM\Column(type: 'message_type')]
    private MessageType $type;

    public function __construct(string $message, MessageType $type = MessageType::NOTICE)
    {
        $this->id = new Ulid();
        $this->message = $message;
        $this->type = $type;
        $this->dateCreatedAt = new \DateTimeImmutable();
        $this->dateUpdateAt = new \DateTimeImmutable();
    }

    public function getId(): Ulid
    {
        return $this->id;
    }

    public function getType(): MessageType
    {
        return $this->type;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getDateCreatedAt(): \DateTimeImmutable
    {
        return $this->dateCreatedAt;
    }

    public function getDateUpdatedAt(): \DateTimeImmutable
    {
        return $this->dateUpdateAt;
    }

    public function setDateUpdateAt(\DateTimeImmutable $dateTime): void
    {
        $this->dateUpdateAt = $dateTime;
    }
}

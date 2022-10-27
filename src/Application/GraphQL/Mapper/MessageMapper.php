<?php

namespace AppName\Application\GraphQL\Mapper;

use AppName\Application\GraphQL\Model\MessageType;
use AppName\Domain\Entity\Message;

class MessageMapper
{
    public static function map(?Message $entity): ?MessageType
    {
        if ($entity === null) {
            return null;
        }

        $type = new MessageType();
        $type->id = $entity->getId()->toBase32();
        $type->text = $entity->getMessage();
        $type->dateCreatedAt = $entity->getDateCreatedAt();
        $type->dateUpdateAt = $entity->getDateUpdatedAt();

        return $type;
    }
}
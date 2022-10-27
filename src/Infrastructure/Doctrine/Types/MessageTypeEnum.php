<?php

namespace AppName\Infrastructure\Doctrine\Types;

use AppName\Domain\Enum\MessageType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class MessageTypeEnum extends StringType
{
    public function getName(): string
    {
        return 'message_type';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?MessageType
    {
        $value = parent::convertToPHPValue($value, $platform);
        return $value === null ? null : MessageType::tryFrom($value);
    }

    /**
     * @param MessageType $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value === null ? null : $value->value;
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        $values = [];
        foreach (MessageType::cases() as $case) {
            $values[] = $case->value;
        }
        return sprintf("ENUM('%s')", implode("','", $values));
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
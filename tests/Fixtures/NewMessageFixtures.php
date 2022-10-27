<?php

namespace AppName\Tests\Fixtures;

use AppName\Domain\Entity\Message;
use AppName\Domain\Enum\MessageType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class NewMessageFixtures extends Fixture implements FixtureGroupInterface
{
    public const DEMO_MESSAGE = 'demo-message';

    public function load(ObjectManager $manager): void
    {
        $message = new Message('Demo fixture', MessageType::ALARM);
        $manager->persist($message);

        $manager->flush();

        $this->addReference(self::DEMO_MESSAGE, $message);
    }

    public static function getGroups(): array
    {
         return ['dev', 'message'];
    }
}

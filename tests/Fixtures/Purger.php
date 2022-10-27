<?php

namespace AppName\Tests\Fixtures;

use Doctrine\Bundle\FixturesBundle\Purger\PurgerFactory;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Purger\PurgerInterface;
use Doctrine\ORM\EntityManagerInterface;

class Purger implements PurgerFactory
{

    public function createForEntityManager(
        ?string $emName,
        EntityManagerInterface $em,
        array $excluded = [],
        bool $purgeWithTruncate = false
    ): PurgerInterface {
        $excludeDictionaries = [
            'dict_table_1',
        ];

        return new ORMPurger($em, array_merge($excluded, $excludeDictionaries));
    }
}
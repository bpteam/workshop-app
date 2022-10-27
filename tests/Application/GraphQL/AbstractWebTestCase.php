<?php

namespace AppName\Tests\Application\GraphQL;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractWebTestCase extends WebTestCase
{
    protected static function createGraphQLClient(
        string $idUser,
        string $legacyIdUser,
        array $roles,
        array $headers = [],
    ): KernelBrowser {
        return parent::createClient([], [
            'HTTP_X-USER-ID' => $idUser,
            'HTTP_X-USER-LEGACY-ID' => $legacyIdUser,
            'HTTP_X-USER-ROLES' => implode(',', $roles),
            'CONTENT_TYPE' => 'application/json',
        ] + $headers);
    }
}
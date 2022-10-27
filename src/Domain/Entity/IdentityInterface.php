<?php

namespace AppName\Domain\Entity;

use Symfony\Component\Uid\Ulid;

interface IdentityInterface
{
    public function getId(): Ulid;
    public function hasRole(string $role): bool;
}
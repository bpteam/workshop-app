<?php

namespace AppName\Domain\Entity;

use AppName\Domain\Enum\UserRoleCollection;
use Symfony\Component\Uid\Ulid;

class Identity implements IdentityInterface
{
    public function __construct(
        public readonly Ulid $id,
        public readonly int $legacyId,
        public readonly UserRoleCollection $roles,
    ) {}

    public function getId(): Ulid
    {
        return $this->id;
    }

    public function getLegacyId(): int
    {
        return $this->legacyId;
    }

    public function getRoles()
    {
        static $roles = [];
        if (empty($roles)) {
            foreach ($this->roles as $role) {
                $roles[] = $role->value;
            }
            $roles = array_unique($roles);
        }

        return $roles;
    }

    public function hasRole(string $role): bool
    {
        foreach ($this->getRoles() as $userRole) {
            if ($userRole === $role) {
                return true;
            }
        }

        return false;
    }
}
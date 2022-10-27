<?php

namespace AppName\Application\Controller;

use AppName\Domain\Entity\Identity;
use AppName\Domain\Entity\IdentityInterface;
use AppName\Domain\Enum\UserRole;
use AppName\Domain\Enum\UserRoleCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as FrameworkController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Uid\Ulid;

class AbstractController extends FrameworkController
{
    public function getFederationUser(Request $request): ?IdentityInterface
    {
        $id = $request->headers->get('x-user-id');
        if ($id === null) {
            return null;
        }

        $legacyId = $request->headers->get('x-user-legacy-id');
        $roles = $request->headers->get('roles');

        $rolesList = [];
        foreach (explode(',', $roles ?? '') as $role) {
            if (UserRole::tryFrom($role) !== null) {
                $rolesList[]  = UserRole::from($role);
            }
        }
        return new Identity(
            Ulid::fromString($id),
            (int) $legacyId,
            new UserRoleCollection($rolesList),
        );
    }

    protected function getTraceID(Request $request): ?string
    {
        return $request->headers->get('x-request-id');
    }
}
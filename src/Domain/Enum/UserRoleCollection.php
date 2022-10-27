<?php

namespace AppName\Domain\Enum;

use AppName\Domain\Collection\GenericCollection;

/**
 * @method UserRole current()
 */
final class UserRoleCollection extends GenericCollection
{
    public function __construct(iterable $elements) {
        parent::__construct(UserRole::class, $elements);
    }
}
<?php

declare (strict_types=1);
namespace AppName\Application\GraphQL\ResolverArgs\Query;

use Axtiva\FlexibleGraphql\Type\InputType;

/**
 * This code is @generated by axtiva/flexible-graphql-php do not edit it
 * PHP representation of graphql field args of Query._entities
 * @property iterable $representations 
 */
final class _entitiesResolverArgs extends InputType
{
    protected function decorate($name, $value)
    {
        if ($value === null) {
            return null;
        }

        return $value;
    }
}
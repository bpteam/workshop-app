<?php

declare (strict_types=1);
namespace AppName\Application\GraphQL\ResolverArgs\Mutation;

use Axtiva\FlexibleGraphql\Type\InputType;
use AppName\Application\GraphQL\Model\UpdateMessageInputInputType;

/**
 * This code is @generated by axtiva/flexible-graphql-php do not edit it
 * PHP representation of graphql field args of Mutation.updateMessage
 * @property UpdateMessageInputInputType $input 
 */
final class UpdateMessageResolverArgs extends InputType
{
    protected function decorate($name, $value)
    {
        if ($value === null) {
            return null;
        }

        if ($name === 'input') {
            return new UpdateMessageInputInputType($value);
        }

        return $value;
    }
}
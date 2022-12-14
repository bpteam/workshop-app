<?php

declare (strict_types=1);
namespace AppName\Application\GraphQL\Resolver\Mutation;

use AppName\Application\GraphQL\Mapper\MessageMapper;
use AppName\Domain\UseCase\MessageUseCase;
use Axtiva\FlexibleGraphql\Generator\Exception\NotImplementedResolver;
use GraphQL\Type\Definition\ResolveInfo;
use Axtiva\FlexibleGraphql\Resolver\ResolverInterface;
use AppName\Application\GraphQL\ResolverArgs\Mutation\UpdateMessageResolverArgs;
use AppName\Application\GraphQL\Model\MessageType;
use Symfony\Component\Uid\Ulid;

/**
 * This code is @generated by axtiva/flexible-graphql-php
 * This is resolver for Mutation.updateMessage
 */
final class UpdateMessageResolver implements ResolverInterface
{
    public function __construct(
        private readonly MessageUseCase $messageUseCase,
    ){}

    /**
     * @param $rootValue
     * @param UpdateMessageResolverArgs $args
     * @param $context
     * @param ResolveInfo $info
     * @return ?MessageType
     */
    public function __invoke($rootValue, $args, $context, ResolveInfo $info)
    {
        $message = $this->messageUseCase->updateMessage(Ulid::fromString($args->input->id), $args->input->text);

        return MessageMapper::map($message);
    }
}
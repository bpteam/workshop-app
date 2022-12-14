<?php

declare (strict_types=1);
namespace AppName\Application\GraphQL\Representation;

use AppName\Application\GraphQL\Mapper\MessageMapper;
use AppName\Domain\UseCase\MessageUseCase;
use GraphQL\Type\Definition\ResolveInfo;
use Axtiva\FlexibleGraphql\Federation\Representation;
use Axtiva\FlexibleGraphql\Federation\Resolver\FederationRepresentationResolverInterface;
use Symfony\Component\Uid\Ulid;

/**
 * This code is @generated by axtiva/flexible-graphql-php
 * Representation resolver for federated graphql type Message
 */
final class MessageRepresentation implements FederationRepresentationResolverInterface
{
    public function __construct(
        private readonly MessageUseCase $messageUseCase,
    ){}

    public function getTypeName(): string
    {
        return 'Message';
    }

    public function __invoke(Representation $representation, $context, ResolveInfo $info)
    {
        $message = $this->messageUseCase->findById(Ulid::fromString($representation->getFields()['id']));

        return MessageMapper::map($message);
    }
}
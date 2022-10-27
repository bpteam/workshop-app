<?php

namespace AppName\Application\Controller;

use GraphQL\Error\DebugFlag;
use GraphQL\GraphQL;
use GraphQL\Server\ServerConfig;
use GraphQL\Server\StandardServer;
use GraphQL\Type\Schema;
use GraphQL\Validator\Rules;
use AppName\Application\GraphQL\Context;
use AppName\Application\GraphQL\TypeRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GraphqlController extends AbstractController
{
    private HttpMessageFactoryInterface $httpMessageFactory;
    private TypeRegistry $typeRegistry;
    private LoggerInterface $logger;
    private bool $debugMode;

    public function __construct(
        TypeRegistry $typeRegistry,
        HttpMessageFactoryInterface $httpMessageFactory,
        LoggerInterface $logger,
        $debugMode = false
    ) {
        $this->httpMessageFactory = $httpMessageFactory;
        $this->typeRegistry = $typeRegistry;
        $this->logger = $logger;
        $this->debugMode = $debugMode;
    }

    #[Route('/graphql', name: 'graphql')]
    public function __invoke(Request $request): Response
    {
        $validatorRules = array_merge(
            GraphQL::getStandardValidationRules(),
            [
                new Rules\QueryComplexity(PHP_INT_MAX),
                new Rules\QueryDepth(PHP_INT_MAX),
            ]
        );
        $psrRequest = $this->httpMessageFactory
            ->createRequest($request)
            ->withParsedBody(json_decode($request->getContent(), true)) // huck for request body 😱
        ;
        $config = ServerConfig::create()
            ->setSchema(new Schema([
                'query' => $this->typeRegistry->getType('Query'),
                'mutation' => $this->typeRegistry->getType('Mutation'),
                'typeLoader' => fn($name) => $this->typeRegistry->getType($name),
            ]))
            ->setRootValue([])
            ->setContext(new Context($this->getFederationUser($request), $psrRequest, (string)$this->getTraceID($request)))
            ->setValidationRules($validatorRules)
            ->setDebugFlag($this->debugMode ? DebugFlag::INCLUDE_DEBUG_MESSAGE | DebugFlag::INCLUDE_TRACE : DebugFlag::NONE)
        ;

        $server = new StandardServer($config);
        $result = $server->executePsrRequest($psrRequest);
        return new JsonResponse($result);
    }
}

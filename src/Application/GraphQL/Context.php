<?php

namespace AppName\Application\GraphQL;

use AppName\Domain\Entity\IdentityInterface;
use ArrayObject;
use Psr\Http\Message\RequestInterface;

class Context extends ArrayObject
{
    public function __construct(
        ?IdentityInterface $user,
        RequestInterface $request,
        string $traceId
    ) {
        parent::__construct([
            'auth' => [
                'user' => $user,
            ],
            'request' => $request,
            'trace_id' => $traceId,
        ]);
    }

    /**
     * @return IdentityInterface|null
     */
    public function getUser(): ?IdentityInterface
    {
        return $this['auth']['user'];
    }

    public function getRequest(): RequestInterface
    {
        return $this['request'];
    }

    public function getTraceID(): string
    {
        return $this['trace_id'];
    }
}
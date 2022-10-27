<?php

namespace AppName\Infrastructure\Messenger;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Retry\RetryStrategyInterface;

class InfinityRetry implements RetryStrategyInterface
{
    public function isRetryable(Envelope $message, \Throwable $throwable = null): bool
    {
        return true;
    }

    public function getWaitingTime(Envelope $message, \Throwable $throwable = null): int
    {
        return 1000;
    }
}
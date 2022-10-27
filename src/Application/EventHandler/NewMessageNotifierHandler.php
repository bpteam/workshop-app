<?php
namespace AppName\Application\EventHandler;

use AppName\Domain\Event\NewMessage;
use AppName\Domain\UseCase\NotificationUseCase;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Uid\Ulid;

class NewMessageNotifierHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly NotificationUseCase $notificationUseCase,
    ) {}

    public function __invoke(NewMessage $event)
    {
        $this->notificationUseCase->newMessageNotification(Ulid::fromString($event->id));
    }
}
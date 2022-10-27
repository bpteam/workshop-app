<?php

namespace AppName\Infrastructure\Repository;

use AppName\Domain\Entity\Message;
use AppName\Domain\Entity\MessageCollection;
use AppName\Domain\Repository\MessageRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;
use Symfony\Component\Uid\Ulid;
use Symfony\Contracts\Cache\ItemInterface;

class MessageCachedRepository extends MessageRepository implements MessageRepositoryInterface
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly TagAwareAdapterInterface $cache,
    ) {
        parent::__construct($registry);
    }

    public function findById(Ulid $id): ?Message
    {
        return $this->cache->get(
            sprintf('message_%s', $id->toBase32()),
            function(ItemInterface $item, bool &$save) use ($id) {
                $entity = parent::findById($id);
                $item->expiresAfter(3600);
                if ($entity) {
                    $item->tag([$this->getEntityTag($entity)]);
                }
                return $entity;
            },
            1.0
        );
    }

    public function findAfter(\DateTimeImmutable $time, string $newCursor = null): MessageCollection
    {
        return parent::findAfter($time, $newCursor);
    }

    public function save(Message $entity): Message
    {
        /** @var Message $entity */
        $entity = $this->getEntityManager()->getUnitOfWork()->merge($entity);
        parent::save($entity);
        return $entity;
    }

    public function invalidateCache(Message $entity): void
    {
        $this->cache->invalidateTags([$this->getEntityTag($entity)]);
    }

    private function getEntityTag(Message $entity): string
    {
        return sprintf('message_%s', $entity->getId()->toBase32());
    }
}
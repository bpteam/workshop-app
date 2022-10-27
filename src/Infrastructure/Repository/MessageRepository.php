<?php

namespace AppName\Infrastructure\Repository;

use AppName\Domain\Entity\Message;
use AppName\Domain\Entity\MessageCollection;
use AppName\Domain\Repository\MessageRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Ulid;

/**
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository implements MessageRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function findById(Ulid $id): ?Message
    {
        return $this->find($id);
    }

    public function save(Message $entity): Message
    {
        $this->_em->persist($entity);
        $this->_em->flush();

        return $entity;
    }

    public function findAfter(\DateTimeImmutable $time, string $cursor = null): MessageCollection
    {
        $limit = 10;

        $queryBuilder = $this->createQueryBuilder('c');
        $e = $queryBuilder->expr();
        $queryBuilder
            ->where($e->gte('dateCreatedAt', ':time'))
            ->orderBy($e->desc('id'))
            ->setMaxResults($limit)
        ;
        if ($cursor) {
            $queryBuilder->andWhere($e->lt('id', ':cursor'));
        }

        $result = $queryBuilder->getQuery()->toIterable([
            'time' => $time,
            'cursor' => Ulid::fromString($cursor),
        ]);

        $itemList = [];
        /** @var Message $item */
        foreach ($result as $item) {
            $itemList[] = $item;
        }
        $newCursor = null;
        if (isset($item) && count($itemList) === $limit) {
            $newCursor = $item->getId()->toBase32();
        }

        return new MessageCollection($itemList, $newCursor);
    }
}

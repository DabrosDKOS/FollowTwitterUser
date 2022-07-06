<?php

namespace App\Repository;

use App\Entity\TwitterUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TwitterUser>
 *
 * @method TwitterUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method TwitterUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method TwitterUser[]    findAll()
 * @method TwitterUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TwitterUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TwitterUser::class);
    }

    public function add(TwitterUser $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TwitterUser $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return TwitterUser[] Returns an array of TwitterUser objects
     */
    public function findOldUpdate(): array
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.updateDateAt', 'ASC')
            ->setMaxResults(20)
            ->getQuery()
            ->getResult();
    }
}

<?php

namespace App\Repository;

use App\Entity\TwitterUserFollows;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TwitterUserFollows>
 *
 * @method TwitterUserFollows|null find($id, $lockMode = null, $lockVersion = null)
 * @method TwitterUserFollows|null findOneBy(array $criteria, array $orderBy = null)
 * @method TwitterUserFollows[]    findAll()
 * @method TwitterUserFollows[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TwitterUserFollowsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TwitterUserFollows::class);
    }

    public function add(TwitterUserFollows $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TwitterUserFollows $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return TwitterUserFollows[] Returns an array of TwitterUserFollows objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TwitterUserFollows
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

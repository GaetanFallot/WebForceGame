<?php

namespace App\Repository;

use App\Entity\ForumPostComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ForumPostComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method ForumPostComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method ForumPostComment[]    findAll()
 * @method ForumPostComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForumPostCommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ForumPostComment::class);
    }

    // /**
    //  * @return ForumPostComment[] Returns an array of ForumPostComment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ForumPostComment
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

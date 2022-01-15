<?php

namespace App\Repository;

use App\Entity\DeleteUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DeleteUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeleteUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeleteUser[]    findAll()
 * @method DeleteUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeleteUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeleteUser::class);
    }

    // /**
    //  * @return DeleteUser[] Returns an array of DeleteUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DeleteUser
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

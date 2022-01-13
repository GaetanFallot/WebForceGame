<?php

namespace App\Repository;

use App\Entity\Characters;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Characters|null find($id, $lockMode = null, $lockVersion = null)
 * @method Characters|null findOneBy(array $criteria, array $orderBy = null)
 * @method Characters[]    findAll()
 * @method Characters[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CharactersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Characters::class);
    }

    public function findAllCharactersButNotMine(?User $user): array
    {
        $queryBuilder = $this->createQueryBuilder('characters');
        if ($user) {
            $queryBuilder
                    ->andWhere('characters.user != :user')
                    ->setParameter('user', $user)
            ;
        }
        return $queryBuilder
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Characters[] Returns an array of Characters objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Characters
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

<?php

namespace App\Repository;

use App\Entity\ProspectStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProspectStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProspectStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProspectStatus[]    findAll()
 * @method ProspectStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProspectStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProspectStatus::class);
    }

    // /**
    //  * @return ProspectStatus[] Returns an array of ProspectStatus objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProspectStatus
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

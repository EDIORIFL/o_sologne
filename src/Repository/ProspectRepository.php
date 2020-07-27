<?php

namespace App\Repository;

use App\Entity\Prospect;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Prospect|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prospect|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prospect[]    findAll()
 * @method Prospect[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProspectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prospect::class);
    }

    public function findBySearchForm(array $options)
    {
        $qb = $this->createQueryBuilder('p');
        if ($options['date_created'] != null) {
            $date_created = $options['date_created'];
            $qb->andWhere('p.datecreated < :date_created');
            $qb->setParameter('date_created', "$date_created");
        }
        if ($options['postal_code'] != null) {
            $postalCode = $options['postal_code'];
            $qb->andWhere('p.address LIKE :postal_code');
            $qb->setParameter('postal_code', "%$postalCode%");
        }
        if ($options['activity_area'] != null) {
            $activityArea = $options['activity_area'];
            $qb->andWhere('p.idactivityarea = :activity_area');
            $qb->setParameter('activity_area', $activityArea);
        }
        if ($options['status'] != null) {
            $status = $options['status'];
            $qb->andWhere('p.idprospectstatus = :status');
            $qb->setParameter('status', $status);
        }
        if ($options['support'] != null) {
            $support = $options['support'];
            $qb->andWhere('p.idsupport = :support');
            $qb->setParameter('support', $support);
        }
        return $qb->getQuery()->getResult();

    }

    // /**
    //  * @return Prospect[] Returns an array of Prospect objects
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
    public function findOneBySomeField($value): ?Prospect
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

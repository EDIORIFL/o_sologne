<?php

namespace App\Repository;

use App\Entity\Command;
use App\Entity\Prospect;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Command|null find($id, $lockMode = null, $lockVersion = null)
 * @method Command|null findOneBy(array $criteria, array $orderBy = null)
 * @method Command[]    findAll()
 * @method Command[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Command::class);
    }

    public function findByProspect($id)
    {
        $qb = $this->createQueryBuilder('c');
        $qb->where('c.idprospect = :id')
            ->groupBy('c.id')
            ->addGroupBy('c.idsupport')
            ->setParameter(':id', $id);
        return $qb->getQuery()->getResult();
    }

    public function addSupportFilter($id, $qb = null)
    {
        if (!$qb || $qb === null) {
            $qb = $this->createQueryBuilder('c');
        }
        $qb->where('c.idsupport = :id')
            ->setParameter('id', $id)
            ->groupBy('c.id')
            ->addGroupBy('c.idprospect');
        return $qb;
        // return $qb->getQuery()->getResult();
    }

    // /**
    //  * @return Command[] Returns an array of Command objects
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
    public function findOneBySomeField($value): ?Command
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

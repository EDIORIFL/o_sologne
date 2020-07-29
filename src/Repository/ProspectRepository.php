<?php

namespace App\Repository;

use App\Entity\Prospect;
use App\Entity\Command;
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

    public function addFilterToSearch($options, $qb, $table, $column, $operator, $token)
    {
        if ($options[$token] !== null) {
            $parameter = $options[$token];
            $qb->andWhere("{$table}.{$column} {$operator} :{$token}");
            
            switch ($operator) {
                case 'LIKE':
                    $qb->setParameter($token, "%{$parameter}%");
                    break;
                default:
                    $qb->setParameter($token, $parameter);
                    break;
            }
        }

        return $qb;
    }

    public function findBySearchForm(array $options)
    {
        $support = false;

        if ($options['support'] !== null) {
            $qb = $this->createQueryBuilder('lol');
            $support = $options['support'];
            $qb->select('c, p')
                ->from('App:Command', 'c')
                ->join('c.idprospect', 'p')
                ->where('c.idsupport = :support')
                ->setParameter('support', $support->getId());
        }
        else {
            $qb = $this->createQueryBuilder('p');
        }

        $qb = $this->addFilterToSearch($options, $qb, 'p', 'datecreated', '<', 'date_created');
        $qb = $this->addFilterToSearch($options, $qb, 'p', 'address', 'LIKE', 'postal_code');
        $qb = $this->addFilterToSearch($options, $qb, 'p', 'idactivityarea', '=', 'activity_area');
        $qb = $this->addFilterToSearch($options, $qb, 'p', 'idprospectstatus', '=', 'status');

        // dd($options['postal_code']);

        /*
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
        */
        
        // dd($qb->getQuery());
        
        $results = $qb->getQuery()->getResult();

        if ($support) {
            $prospects = [];
            
            foreach ($results as $result) {
                $prospects[] = $result->getIdprospect();
            }

            $results = $prospects;
        }

        return $results;
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

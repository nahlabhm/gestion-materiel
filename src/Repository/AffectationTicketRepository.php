<?php

namespace App\Repository;

use App\Entity\AffectationTicket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AffectationTicket|null find($id, $lockMode = null, $lockVersion = null)
 * @method AffectationTicket|null findOneBy(array $criteria, array $orderBy = null)
 * @method AffectationTicket[]    findAll()
 * @method AffectationTicket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AffectationTicketRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AffectationTicket::class);
    }

    // /**
    //  * @return AffectationTicket[] Returns an array of AffectationTicket objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AffectationTicket
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

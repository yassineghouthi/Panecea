<?php

namespace App\Repository;

use App\Entity\HopitalImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HopitalImage>
 *
 * @method HopitalImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method HopitalImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method HopitalImage[]    findAll()
 * @method HopitalImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HopitalImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HopitalImage::class);
    }

//    /**
//     * @return HopitalImage[] Returns an array of HopitalImage objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?HopitalImage
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

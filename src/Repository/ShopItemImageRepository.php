<?php

namespace App\Repository;

use App\Entity\ShopItemImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ShopItemImage|null find($ShopItemImageId, $lockMode = null, $lockVersion = null)
 * @method ShopItemImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShopItemImage[]    findAll()
 * @method ShopItemImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShopItemImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShopItemImage::class);
    }

    // /**
    //  * @return ShopItemImage[] Returns an array of ShopItemImage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ShopItemImage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
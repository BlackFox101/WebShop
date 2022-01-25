<?php

namespace App\Repository;

use App\Entity\ShopItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ShopItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShopItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShopItem[]    findAll()
 * @method ShopItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShopItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShopItem::class);
    }

    /**
     * @param int $pageSize
     * @param int $offset
     * @param string|null $name
     * @return Paginator
     */
    public function getProductsPaginator(int $pageSize, int $offset, string $name = null): Paginator
    {
        $query = $this->createQueryBuilder('product')
            ->andWhere('product.isHidden = 0');
        if ($name)
        {
            $query->andWhere('product.name LIKE :name')
                ->setParameter('name', "%$name%");
        }
        $query->setMaxResults($pageSize)
            ->setFirstResult($offset * $pageSize)
            ->getQuery();

        return new Paginator($query);
    }

    // /**
    //  * @return ShopItem[] Returns an array of ShopItem objects
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
    public function findOneBySomeField($value): ?ShopItem
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

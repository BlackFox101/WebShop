<?php

namespace App\Repository;

use App\Entity\Shop;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Shop|null find($id, $lockMode = null, $lockVersion = null)
 * @method Shop|null findOneBy(array $criteria, array $orderBy = null)
 * @method Shop[]    findAll()
 * @method Shop[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShopRepository extends ServiceEntityRepository
{
    private const DEFAULT_PAGE = 0;
    private const PAGINATOR_PER_PAGE = 5;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Shop::class);
    }

    /**
     * @param string|null $name
     * @param int $offset
     * @return Paginator
     */
    public function getShopPaginator(int $pageSize, int $offset, string $name = null): Paginator
    {
        $query = $this->createQueryBuilder('shop')
                       ->andWhere('shop.isHidden = 0');
        if ($name)
        {
            $query->andWhere('shop.name LIKE :name')
                  ->setParameter('name', "%$name%");
        }
        $query->setMaxResults($pageSize)
              ->setFirstResult($offset * $pageSize)
              ->getQuery();


        return new Paginator($query);
    }


    // /**
    //  * @return Shop[] Returns an array of Shop objects
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
    public function findOneBySomeField($value): ?Shop
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

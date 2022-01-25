<?php

namespace App\Repository;

use App\Entity\Shop;
use App\Entity\ShopItem;
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
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Shop::class);
    }

    /**
     * @param int $pageSize
     * @param int $offset
     * @param string|null $name
     * @return Paginator
     */
    public function getShopsPaginator(int $pageSize, int $offset, string $name = null): Paginator
    {
        $itemRepo = $this->getEntityManager()->getRepository(ShopItem::class);
        $query = $itemRepo->createQueryBuilder('i')
            ->where('i.category = :categoryId')
            ->setParameter('categoryId', 0);
        $temp = $query->getMaxResults();

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

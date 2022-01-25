<?php
declare(strict_types=1);

namespace App\Services\Pagination;

use App\Entity\Shop;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Exception;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;

class PaginationService
{
    private const SEARCH_PAGE = 'page';
    private const SEARCH_NAME = 'name';
    private const CATEGORY = 'category';
    private const DEFAULT_PAGE_NUMBER = 1;
    private const PAGE_SIZE = 4;

    private EntityManagerInterface $entityManager;
    private PaginatorInterface $paginator;
    private string $entityName;

    private ?int $searchPageNumber;
    private ?string $searchName;
    private ?int $searchCategoryId;

    public function __construct(string $entityName, EntityManagerInterface $entityManager, Request $request)
    {
        $this->entityName = $entityName;
        $this->entityManager = $entityManager;
        if (!in_array($entityName, [Shop::class, Product::class]))
        {
            throw new RuntimeException('Paginator does not support this class');
        }
        $this->getSearchParams($request);
        $paginatorPage = $this->getPaginatorPageNumber($this->searchPageNumber);
        $this->paginator = $this->getWebShopPaginator($paginatorPage);
    }

    public function getPaginator(): PaginatorInterface
    {
        return $this->paginator;
    }

    private function getWebShopPaginator(int $paginatorPage): PaginatorInterface
    {
        $symfonyPaginator = $this->getSymfonyPaginator($paginatorPage);
        $items = $symfonyPaginator->getIterator();
        $temp = $symfonyPaginator->count();
        $maxPageCount = (int)ceil($symfonyPaginator->count() / self::PAGE_SIZE);
        $pageNumbers = $this->getPageNumbers($this->searchPageNumber, $maxPageCount);
        return new WebShopPaginator($items, $this->searchPageNumber, $maxPageCount, $pageNumbers, $symfonyPaginator->count(), $this->searchName);
    }

    private function getSearchParams(Request $request)
    {
        $this->searchPageNumber = (int)$request->get(self::SEARCH_PAGE, self::DEFAULT_PAGE_NUMBER);
        $this->searchName = $request->get(self::SEARCH_NAME) ? $request->get(self::SEARCH_NAME) : null;
        $this->searchCategoryId = $request->get(self::CATEGORY) ? (int)$request->get(self::CATEGORY) : null;
    }

    /** @return int[] */
    private function getPageNumbers(int $clientPage, int $maxPageCount): array
    {
        $pages = [];

        if ($clientPage != 1)
        {
            $pages[] = 1;
        }
        for ($i = $clientPage-3; $i < $clientPage; $i++)
        {
            if ($i <= 1)
            {
                break;
            }
            $pages[] = $i;
        }
        $pages[] = $clientPage;
        for ($i = $clientPage+1; $i <= $clientPage+3; $i++)
        {
            if ($i >= $maxPageCount)
            {
                break;
            }
            $pages[] = $i;
        }
        if ($clientPage != $maxPageCount)
        {
            $pages[] = $maxPageCount;
        }

        return $pages;
    }

    private function getPaginatorPageNumber(int $clientPage): int
    {
        if ($clientPage <= 0)
        {
            return 0;
        }
        return $clientPage - 1;
    }

    private function getSymfonyPaginator(int $page): Paginator
    {
        return new Paginator($this->getPaginatorQuery($page));
    }

    private const IS_HIDDEN_PROPERTY = 'isHidden';
    private const CATEGORY_PROPERTY = 'category';
    private const NAME_PROPERTY = 'name';

    private function getPaginatorQuery(int $page): Query
    {
        $alias = 'i';
        $itemRepo = $this->entityManager->getRepository($this->entityName);
        $query = $itemRepo->createQueryBuilder($alias);

        $this->addIsHiddenFiler($query, $alias);
        $this->addCategoryFilter($query, $alias);
        $this->addNameFilter($query, $alias);

        $query->setMaxResults(self::PAGE_SIZE);
        $query->setFirstResult($page * self::PAGE_SIZE);

        return $query->getQuery();
    }

    private function addIsHiddenFiler(QueryBuilder $query, string $alias)
    {
        $isHiddenProperty = self::IS_HIDDEN_PROPERTY;
        if ($this->isExistProperty($isHiddenProperty)) {
            $query->where("$alias.$isHiddenProperty = 0");
        }
    }

    private function addCategoryFilter(QueryBuilder $query, string $alias)
    {
        $categoryProperty = self::CATEGORY_PROPERTY;
        if ($this->searchCategoryId && $this->isExistProperty($categoryProperty))
        {
            $query->where("$alias.$categoryProperty = :$categoryProperty");
            $query->setParameter($categoryProperty, $this->searchCategoryId);
        }
    }

    private function addNameFilter(QueryBuilder $query, string $alias)
    {
        $nameProperty = self::NAME_PROPERTY;
        if ($this->searchName && $this->isExistProperty($nameProperty))
        {
            $query->where("$alias.$nameProperty like :$nameProperty");
            $query->setParameter($nameProperty, '%'.$this->searchName.'%');
        }
    }

    private function isExistProperty(string $property): bool
    {
        return property_exists($this->entityName, $property);
    }

}
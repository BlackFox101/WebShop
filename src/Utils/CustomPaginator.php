<?php
declare(strict_types=1);

namespace App\Utils;

use ArrayIterator;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Exception;

class CustomPaginator
{
    private Paginator $paginator;
    private int $currentPage;
    private int $pageCount;
    private ?string $name;
    private array $pages;

    public function __construct(Paginator $paginator, int $pageSize, int $currentPage, ?string $name)
    {
        $this->paginator = $paginator;
        $this->currentPage = $currentPage;
        $this->name = $name;
        $this->pageCount = (int)ceil($paginator->count() / $pageSize);

        if ($currentPage != 1)
        {
            $this->pages[] = 1;
        }
        for ($i = $currentPage-3; $i < $currentPage; $i++)
        {
            if ($i <= 1)
            {
                break;
            }
            $this->pages[] = $i;
        }
        $this->pages[] = $currentPage;
        for ($i = $currentPage+1; $i <= $currentPage+3; $i++)
        {
            if ($i >= $this->pageCount)
            {
                break;
            }
            $this->pages[] = $i;
        }
        if ($currentPage != $this->pageCount)
        {
            $this->pages[] = $this->pageCount;
        }
    }

    public function getCurrentPageNumber(): int
    {
        return $this->currentPage;
    }

    public function getPages(): array
    {
        return count($this->pages) == 1 ? [] : $this->pages;
    }

    /**
     * @return ArrayIterator
     * @throws Exception
     */
    public function getShops(): ArrayIterator
    {
        return $this->paginator->getIterator();
    }

    public function getShopCount(): int
    {
        return $this->paginator->count();
    }

    public function getMaxPages(): int
    {
        return $this->pageCount;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
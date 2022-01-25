<?php
declare(strict_types=1);

namespace App\Services\Pagination;

use ArrayIterator;

class WebShopPaginator implements PaginatorInterface
{
    private ArrayIterator $items;
    private int $currentPageNumber;
    private int $maxPageNumber;
    private ?string $name;
    /** @var int[] */
    private array $pageNumbers;
    private int $maxItemCount;

    /**
     * @param ArrayIterator $items
     * @param int $currentPageNumber
     * @param int[] $pageNumbers
     * @param ?string $name
     */
    public function __construct(ArrayIterator $items, int $currentPageNumber, int $maxPageNumber, array $pageNumbers, int $maxItemCount, string $name = null)
    {
        $this->items = $items;
        $this->currentPageNumber = $currentPageNumber;
        $this->maxPageNumber = $maxPageNumber;
        $this->pageNumbers = $pageNumbers;
        $this->maxItemCount = $maxItemCount;
        $this->name = $name;
    }

    public function getItems(): ArrayIterator
    {
        return $this->items;
    }

    public function getCurrentPageNumber(): int
    {
        return $this->currentPageNumber;
    }

    public function getMaxPageNumber(): int
    {
        return $this->maxPageNumber;
    }

    public function getPageNumbers(): array
    {
        return $this->pageNumbers;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getItemsCount(): int
    {
        return $this->maxItemCount;
    }
}
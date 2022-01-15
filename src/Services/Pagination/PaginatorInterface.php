<?php
declare(strict_types=1);

namespace App\Services\Pagination;

use ArrayIterator;

interface PaginatorInterface
{
    public function getItems(): ArrayIterator;
    public function getCurrentPageNumber(): int;
    public function getMaxPageNumber(): int;
    /** @return int[] */
    public function getPageNumbers(): array;
    public function getItemsCount(): int;
    public function getName(): ?string;
}
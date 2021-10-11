<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatusRepository::class)
 */
class Status
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $statusId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $shop_count;

    /**
     * @ORM\Column(type="integer")
     */
    private $shop_item_count;

    public function getStatusId(): ?int
    {
        return $this->statusId;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getShopCount(): ?int
    {
        return $this->shop_count;
    }

    public function setShopCount(int $shop_count): self
    {
        $this->shop_count = $shop_count;

        return $this;
    }

    public function getShopItemCount(): ?int
    {
        return $this->shop_item_count;
    }

    public function setShopItemCount(int $shop_item_count): self
    {
        $this->shop_item_count = $shop_item_count;

        return $this;
    }
}

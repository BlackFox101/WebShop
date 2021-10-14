<?php

namespace App\Entity;

use App\Repository\ShopItemImageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ShopItemImageRepository::class)
 */
class ShopItemImage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $shopItemImageId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $imagePath;

    /**
     * @ORM\ManyToOne(targetEntity=ShopItem::class, inversedBy="shopItemImages")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="shop_item_id")
     */
    private ShopItem $shopItem;

    public function getId(): ?int
    {
        return $this->shopItemImageId;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(string $imagePath): self
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    public function getShopItem(): ?ShopItem
    {
        return $this->shopItem;
    }

    public function setShopItem(?ShopItem $shopItem): self
    {
        $this->shopItem = $shopItem;

        return $this;
    }
}

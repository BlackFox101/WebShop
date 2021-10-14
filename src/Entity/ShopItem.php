<?php

namespace App\Entity;

use App\Repository\ShopItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity(repositoryClass=ShopItemRepository::class)
 */
class ShopItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $shopItemId;

    /**
     * @ORM\ManyToOne(targetEntity=Shop::class, inversedBy="shopItems")
     * @ORM\JoinColumn(referencedColumnName="shopId")
     */
    private Shop $shop;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private string $description;

    /**
     * @ORM\Column(type="boolean", columnDefinition="TINYINT(1) DEFAULT 0")
     */
    private bool $isHidden;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private float $price;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="shopItems")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="categoryId")
     */
    private Category $category;

    /**
     * @ORM\OneToMany(targetEntity=ShopItemImage::class, mappedBy="shopItem", orphanRemoval=true)
     * @ORM\JoinColumn(referencedColumnName="shopItemImageId")
     * @var ArrayCollection|ShopItemImage[]
     */
    private ArrayCollection|array $shopItemImages;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="user")
     * @ORM\JoinColumn(referencedColumnName="UserId")
     * @var ArrayCollection|User[]
     */
    private ArrayCollection|array $userWhoAddedInFavourites;

    /**
     * @ORM\Column(type="datetime", columnDefinition="TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL")
     */
    private \DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true, columnDefinition="TIMESTAMP NULL")
     */
    private \DateTimeInterface|null $updatedAt;

    #[Pure] public function __construct()
    {
        $this->shopItemImages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->shopItemId;
    }

    public function getShop(): Shop
    {
        return $this->shop;
    }

    public function setShop(?Shop $shop): self
    {
        $this->shop = $shop;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIsHidden(): ?bool
    {
        return $this->isHidden;
    }

    public function setIsHidden(bool $isHidden): self
    {
        $this->isHidden = $isHidden;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|ShopItemImage[]
     */
    public function getShopItemImages(): Collection
    {
        return $this->shopItemImages;
    }

    public function addShopItemImage(ShopItemImage $shopItemImage): self
    {
        if (!$this->shopItemImages->contains($shopItemImage)) {
            $this->shopItemImages[] = $shopItemImage;
            $shopItemImage->setShopItem($this);
        }

        return $this;
    }

    public function removeShopItemImage(ShopItemImage $shopItemImage): self
    {
        if ($this->shopItemImages->removeElement($shopItemImage)) {
            // set the owning side to null (unless already changed)
            if ($shopItemImage->getShopItem() === $this) {
                $shopItemImage->setShopItem(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}

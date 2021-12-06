<?php

namespace App\Entity;

use App\Repository\ShopItemRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
    private $shopItemId;

    /**
     * @ORM\ManyToOne(targetEntity=Shop::class, inversedBy="shopItems")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="shop_id")
     */
    private $shop;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isHidden = false;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="shopItems")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="category_id")
     */
    private $category;

    /**
     * @ORM\Column(type="datetime", columnDefinition="TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true, columnDefinition="TIMESTAMP NULL")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=ShopItemImage::class, mappedBy="shopItem")
     */
    private $shopItemImages;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="favouriteItems")
     * @ORM\JoinColumn(referencedColumnName="user_id")
     */
    private $usersWhoAddedInFavourites;

    public function __construct(Shop $shop)
    {
        $this->shopItemImages = new ArrayCollection();
        $this->shop = $shop;
    }

    public function getId(): ?int
    {
        return $this->shopItemId;
    }

    public function getShop(): ?Shop
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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
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

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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

    /**
     * @return Collection|User[]
     */
    public function getUserWhoAddedInFavourites(): Collection
    {
        return $this->usersWhoAddedInFavourites;
    }

    public function addUserWhoAddedInFavourites(User $user): self
    {
        if (!$this->usersWhoAddedInFavourites->contains($user)) {
            $this->usersWhoAddedInFavourites[] = $user;
            $user->addFavouriteItem($this);
        }

        return $this;
    }

    public function removeUserWhoAddedInFavourites(User $user): self
    {
        if ($this->usersWhoAddedInFavourites->removeElement($user)) {
            $user->removeFavouriteItem($this);
        }

        return $this;
    }
}

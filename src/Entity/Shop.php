<?php

namespace App\Entity;

use App\Repository\ShopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ShopRepository::class)
 */
class Shop
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $shopId;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="shops")
     * @ORM\JoinColumn(nullable=true, referencedColumnName="user_id")
     */
    private User $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="boolean", columnDefinition="TINYINT(1) DEFAULT 0")
     */
    private bool $isHidden;

    /**
     * @ORM\OneToMany(targetEntity=ShopItem::class, mappedBy="shop")
     * @ORM\JoinColumn(nullable=true, referencedColumnName="shop_item_id")
     * @var ArrayCollection|ShopItem[]
     */
    private array|ArrayCollection $shopItems;

    /**
     * @ORM\Column(type="datetime", columnDefinition="TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL")
     */
    private \DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true, columnDefinition="TIMESTAMP NULL")
     */
    private \DateTimeInterface|null $updatedAt;

    public function __construct()
    {
        $this->shopItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->shopId;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $User): self
    {
        $this->user = $User;

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

    public function getIsHidden(): ?bool
    {
        return $this->isHidden;
    }

    public function setIsHidden(bool $isHidden): self
    {
        $this->isHidden = $isHidden;

        return $this;
    }

    /**
     * @return Collection|ShopItem[]
     */
    public function getShopItems(): Collection
    {
        return $this->shopItems;
    }

    public function addShopItem(ShopItem $shopItem): self
    {
        if (!$this->shopItems->contains($shopItem)) {
            $this->shopItems[] = $shopItem;
            $shopItem->setShop($this);
        }

        return $this;
    }

    public function removeShopItem(ShopItem $shopItem): self
    {
        if ($this->shopItems->removeElement($shopItem)) {
            // set the owning side to null (unless already changed)
            if ($shopItem->getShop() === $this) {
                $shopItem->setShop(null);
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

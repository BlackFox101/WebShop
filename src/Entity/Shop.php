<?php

namespace App\Entity;

use App\Repository\ShopRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

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
    private $shopId;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="shops")
     * @ORM\JoinColumn(nullable=true, referencedColumnName="user_id")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime", columnDefinition="TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true, columnDefinition="TIMESTAMP NULL")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isHidden = false;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="shop")
     * @ORM\JoinColumn(nullable=true, referencedColumnName="shop_item_id")
     */
    private $products;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $imageName;

    public function __construct(UserInterface $user)
    {
        $this->products = new ArrayCollection();
        $this->user = $user;
    }

    public function getId(): ?int
    {
        return $this->shopId;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $Product): self
    {
        if (!$this->products->contains($Product)) {
            $this->products[] = $Product;
            $Product->setShop($this);
        }

        return $this;
    }

    public function removeProduct(Product $Product): self
    {
        if ($this->products->removeElement($Product)) {
            // set the owning side to null (unless already changed)
            if ($Product->getShop() === $this) {
                $Product->setShop(null);
            }
        }

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

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $name): self
    {
        $this->imageName = $name;

        return $this;
    }

    public function getPathToImage(): string
    {
        if ($this->imageName)
        {
            return '/uploads/images/'. $this->imageName;
        }

        return '/assets/images/question_icon.svg';
    }
}

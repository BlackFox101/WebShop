<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $userId;

    /** @ORM\Column(type="string", length=255) */
    private string $firstName;

    /** @ORM\Column(type="string", length=255) */
    private string $lastName;

    /** @ORM\Column(type="string", length=180, unique=true) */
    private string $email;

    /** @ORM\Column(type="string", length=180, unique=true) */
    private string $login;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private string $password;

    /** @ORM\Column(type="string", length=50, unique=true) */
    private string $phone;

    /**
     * @ORM\ManyToOne(targetEntity=Role::class, inversedBy="users", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="role_id")
     */
    private Role $role;

    /**
     * @ORM\ManyToOne(targetEntity=Status::class, inversedBy="user", fetch="EAGER")
     * @ORM\JoinColumn(nullable=true, referencedColumnName="status_id")
     */
    private Status $status;

    /**
     * @ORM\OneToMany(targetEntity=Shop::class, mappedBy="User")
     * @ORM\JoinColumn(referencedColumnName="shop_id")
     * @var ArrayCollection|Shop[]
     */
    private ArrayCollection|array $shops;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ShopItem", inversedBy="users")
     * @ORM\JoinTable(name="users_favourites_items",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="user_id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="shop_item_id", referencedColumnName="shop_item_id", unique=true)}
     * )
     * @var ArrayCollection|ShopItem[]
     */
    private ArrayCollection|array $favoritesShopItems;

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
        $this->shops = new ArrayCollection();
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @see UserInterface
     */
    #[Pure] public function getRole(): string
    {
        return $this->role->getName();
    }

    public function setRole(Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|Shop[]
     */
    public function getShops(): Collection
    {
        return $this->shops;
    }

    public function addShop(Shop $shop): self
    {
        if (!$this->shops->contains($shop)) {
            $this->shops[] = $shop;
            $shop->setUser($this);
        }

        return $this;
    }

    public function removeShop(Shop $shop): self
    {
        if ($this->shops->removeElement($shop)) {
            // set the owning side to null (unless already changed)
            if ($shop->getUser() === $this) {
                $shop->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ShopItem[]
     */
    public function getFavoriteShopItems(): Collection
    {
        return $this->favoritesShopItems;
    }

    public function addFavoriteShopItem(ShopItem $shopItem): self
    {
        if (!$this->favoritesShopItems->contains($shopItem)) {
            $this->favoritesShopItems[] = $shopItem;
        }

        return $this;
    }

    public function removeShopItem(ShopItem $shopItem): self
    {
        $this->favoritesShopItems->removeElement($shopItem);

        return $this;
    }
}

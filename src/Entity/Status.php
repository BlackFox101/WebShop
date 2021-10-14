<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

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
    private int $statusId;

    /**
     * @ORM\Column(type="integer")
     */
    private int $shopCount;

    /**
     * @ORM\Column(type="integer")
     */
    private int $shopItemCount;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private int $name;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="role")
     * @ORM\JoinColumn(referencedColumnName="user_id")
     * @var ArrayCollection|User[]
     */
    private ArrayCollection|array $users;

    #[Pure] public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->statusId;
    }

    public function getShopCount(): ?int
    {
        return $this->shopCount;
    }

    public function setShopCount(int $shopCount): self
    {
        $this->shopCount = $shopCount;

        return $this;
    }

    public function getShopItemCount(): ?int
    {
        return $this->shopItemCount;
    }

    public function setShopItemCount(int $shopItemCount): self
    {
        $this->shopItemCount = $shopItemCount;

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

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setStatus($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getStatus() === $this) {
                $user->setStatus(null);
            }
        }

        return $this;
    }
}

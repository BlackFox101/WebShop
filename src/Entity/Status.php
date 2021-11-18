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
     * @ORM\Column(type="integer")
     */
    private $shopCount;

    /**
     * @ORM\Column(type="integer")
     */
    private $shopItemCount;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function getId(): ?int
    {
        return $this->statusId;
    }

    public function getShopCount(): ?int
    {
        return $this->shopCount;
    }

    public function setShowCount(int $shopCount): self
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
}

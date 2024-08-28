<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $fistName = null;

    #[ORM\Column(length: 30)]
    private ?string $lastName = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\OneToMany(targetEntity: OrderMaterial::class, mappedBy: 'orderRef',cascade: ['persist'])]
    private Collection $orderMaterials;

    public function __construct()
    {
        $this->orderMaterials = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFistName(): ?string
    {
        return $this->fistName;
    }

    public function setFistName(string $fistName): static
    {
        $this->fistName = $fistName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection<int, OrderMaterial>
     */
    public function getOrderMaterials(): Collection
    {
        return $this->orderMaterials;
    }

    public function addOrderMaterial(OrderMaterial $orderMaterial): static
    {
        if (!$this->orderMaterials->contains($orderMaterial)) {
            $this->orderMaterials->add($orderMaterial);
            $orderMaterial->setOrderRef($this);
        }

        return $this;
    }

    public function removeOrderMaterial(OrderMaterial $orderMaterial): static
    {
        if ($this->orderMaterials->removeElement($orderMaterial)) {
            // set the owning side to null (unless already changed)
            if ($orderMaterial->getOrderRef() === $this) {
                $orderMaterial->setOrderRef(null);
            }
        }

        return $this;
    }
}

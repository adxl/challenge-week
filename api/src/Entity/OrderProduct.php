<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use App\Repository\OrderProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OrderProductRepository::class)]
class OrderProduct
{
  use TimestampableTrait;

  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  #[Groups(['order:detail'])]
  private ?int $id = null;

  #[ORM\Column]
  #[Groups(['order:detail', 'order:write'])]
  private ?int $quantity = null;

  #[ORM\ManyToOne]
  #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
  #[Groups(['order:detail', 'order:write'])]
  private ?Product $product = null;

  #[ORM\ManyToOne(inversedBy: 'products')]
  #[ORM\JoinColumn(nullable: false)]
  private ?Order $originOrder = null;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function setQuantity(int $quantity): self
  {
    $this->quantity = $quantity;
    return $this;
  }

  public function getQuantity(): ?int
  {
    return $this->quantity;
  }

  public function setProduct(?Product $product): self
  {
    $this->product = $product;
    return $this;
  }
  public function getProduct(): ?Product
  {
    return $this->product;
  }

  public function getOriginOrder(): ?Order
  {
    return $this->originOrder;
  }

  public function setOriginOrder(?Order $originOrder): self
  {
    $this->originOrder = $originOrder;
    return $this;
  }
}
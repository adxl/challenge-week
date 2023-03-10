<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Entity\Traits\TimestampableTrait;
use App\Repository\ProductTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: ProductTypeRepository::class)]
#[ApiResource(
  operations: [
    new GetCollection(),
    new Get(),
    new Post(security: 'is_granted("ROLE_ADMIN")'),
    new Patch(security: 'is_granted("ROLE_ADMIN")'),
    new Delete(security: 'is_granted("ROLE_ADMIN")'),
  ],
)]
class ProductType
{

  use TimestampableTrait;

  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 255)]
  #[Groups(['product:read'])]
  private ?string $name = null;

  #[ORM\Column]
  #[Groups(['product:read', 'order:detail'])]
  private ?int $unit = null;

  #[ORM\Column(length: 10)]
  #[Groups(['product:read', 'order:detail'])]
  private ?string $label = null;

  #[ORM\OneToMany(mappedBy: 'type', targetEntity: Product::class, orphanRemoval: true)]
  private Collection $products;

  public function __construct()
  {
    $this->products = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
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

  public function getUnit(): ?int
  {
    return $this->unit;
  }

  public function setUnit(int $unit): self
  {
    $this->unit = $unit;

    return $this;
  }

  public function getLabel(): ?string
  {
    return $this->label;
  }

  public function setLabel(string $label): self
  {
    $this->label = $label;

    return $this;
  }

  /**
   * @return Collection<int, Product>
   */
  public function getProducts(): Collection
  {
    return $this->products;
  }

  public function addProduct(Product $product): self
  {
    if (!$this->products->contains($product)) {
      $this->products->add($product);
      $product->setType($this);
    }

    return $this;
  }

  public function removeProduct(Product $product): self
  {
    if ($this->products->removeElement($product)) {
      // set the owning side to null (unless already changed)
      if ($product->getType() === $this) {
        $product->setType(null);
      }
    }

    return $this;
  }
}


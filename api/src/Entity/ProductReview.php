<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use App\Repository\ProductReviewRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProductReviewRepository::class)]
#[
  ApiResource(
    operations: [
      new GetCollection(security: 'is_granted("ROLE_ADMIN")'),
      new Patch(),
    ],
    normalizationContext: ['groups' => ['productReviews']]
  )

]
class ProductReview
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  #[Groups(['productReviews', 'order:detail', 'order:read'])]
  private ?int $id = null;

  #[ORM\Column(nullable: true)]
  #[Groups(['productReviews', 'order:detail', 'order:read', 'product:read'])]
  private ?bool $rating = null;

  #[ORM\ManyToOne(inversedBy: 'reviews')]
  #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
  #[Groups(['productReviews', 'order:detail', 'order:read'])]
  private ?Product $product = null;

  #[ORM\ManyToOne(inversedBy: 'productReviews')]
  #[ORM\JoinColumn(nullable: false)]
  #[Groups(['productReviews', 'order:detail', 'order:read'])]
  private ?Order $originOrder = null;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function isRating(): ?bool
  {
    return $this->rating;
  }

  public function setRating(bool $rating): self
  {
    $this->rating = $rating;

    return $this;
  }

  public function getProduct(): ?Product
  {
    return $this->product;
  }

  public function setProduct(?Product $product): self
  {
    $this->product = $product;

    return $this;
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

<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\DelivererReviewRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;

#[ORM\Entity(repositoryClass: DelivererReviewRepository::class)]
#[ApiResource(
  operations: [
    new Get(security: 'is_granted("ROLE_ADMIN")'),
    new GetCollection(security: 'is_granted("ROLE_ADMIN")'),
    new Post(),
    new Put(),
    new Patch(),
    new Delete(),
  ],
  normalizationContext: ['groups' => ['delivererReviews']]
)]
class DelivererReview
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  #[Groups(['delivererReviews', 'order:detail', 'order:read'])]
  private ?int $id = null;

  #[ORM\Column(nullable: true)]
  #[Groups(['delivererReviews', 'order:detail', 'order:read'])]
  private ?int $rating = null;

  #[ORM\Column(type: Types::TEXT, nullable: true)]
  #[Groups(['delivererReviews', 'order:detail', 'order:read'])]
  private ?string $comment = null;

  #[ORM\OneToOne(mappedBy: 'delivererReview', cascade: ['persist', 'remove'])]
  #[Groups(['delivererReviews'])]
  private ?Order $originOrder = null;

  /* #[ORM\OneToOne(inversedBy: 'productOrder', cascade: ['persist', 'remove'])] */
  /* #[Groups(['delivererReviews'])] */
  /* private ?Order $productOrder = null; */

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getRating(): ?int
  {
    return $this->rating;
  }

  public function setRating(?int $rating): self
  {
    $this->rating = $rating;

    return $this;
  }

  public function getComment(): ?string
  {
    return $this->comment;
  }

  public function setComment(?string $comment): self
  {
    $this->comment = $comment;

    return $this;
  }

  /* public function getProductOrder(): ?Order */
  /* { */
  /*   return $this->productOrder; */
  /* } */

  /* public function setProductOrder(?Order $productOrder): self */
  /* { */
  /*   $this->productOrder = $productOrder; */

  /*   return $this; */
  /* } */

  public function getOriginOrder(): ?Order
  {
      return $this->originOrder;
  }

  public function setOriginOrder(?Order $originOrder): self
  {
      // unset the owning side of the relation if necessary
      if ($originOrder === null && $this->originOrder !== null) {
          $this->originOrder->setDelivererReview(null);
      }

      // set the owning side of the relation if necessary
      if ($originOrder !== null && $originOrder->getDelivererReview() !== $this) {
          $originOrder->setDelivererReview($this);
      }

      $this->originOrder = $originOrder;

      return $this;
  }
}

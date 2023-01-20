<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
#[ApiResource]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['delivererReviews'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['delivererReviews'])]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'delivererOrders')]
    #[Groups(['delivererReviews'])]
    private ?User $deliverer = null;

    #[ORM\ManyToOne(inversedBy: 'clientOrders')]
    #[Groups(['delivererReviews'])]
    private ?User $client = null;

    #[ORM\OneToOne(inversedBy: 'originOrder', cascade: ['persist', 'remove'])]
    #[Groups(['delivererReviews'])]
    private ?DelivererReview $delivererReview = null;

    /* #[ORM\OneToOne(inversedBy: 'productOrder', cascade: ['persist', 'remove'])] */
    /* private ?DelivererReview $delivererReview = null; */

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getDeliverer(): ?User
    {
        return $this->deliverer;
    }

    public function setDeliverer(?User $deliverer): self
    {
        $this->deliverer = $deliverer;
        return $this;
    }

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): self
    {
        $this->client = $client;
        return $this;
    }

    /* public function getDelivererReview(): ?DelivererReview */
    /* { */
    /*     return $this->delivererReview; */
    /* } */

    /* public function setDelivererReview(?DelivererReview $delivererReview): self */
    /* { */
    /*     $this->delivererReview = $delivererReview; */
    /*     return $this; */
    /* } */

    public function getDelivererReview(): ?DelivererReview
    {
        return $this->delivererReview;
    }

    public function setDelivererReview(?DelivererReview $delivererReview): self
    {
        $this->delivererReview = $delivererReview;

        return $this;
    }
}

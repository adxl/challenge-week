<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use App\Repository\OrderRepository;
use App\Controller\Order\GetAllOrderController;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
#[ApiResource(operations: [
    new Get(security: 'is_granted("ROLE_ADMIN") or object.getClient() == user', normalizationContext: ["groups" => ['order:detail']]),
    new GetCollection(controller: GetAllOrderController::class, normalizationContext: ["groups" => ['order:read']]),
    new Post(),
    new Put(),
    new Patch(security: 'is_granted("ROLE_ADMIN") 
        or (is_granted("ROLE_DELIVERER") and user.getStatus() == "OPERATIVE" and object.getDeliverer() == null) 
        or (is_granted("ROLE_USER") and user.getClient() == user)'),
    new Delete(),
], normalizationContext: ['groups' => ['order:read', 'order:detail']], )]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['order:read', 'order:detail', 'delivererReviews'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['order:read', 'order:detail', 'delivererReviews'])]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'delivererOrders')]
    #[Groups(['delivererReviews'])]
    private ?User $deliverer = null;

    #[ORM\ManyToOne(inversedBy: 'clientOrders')]
    #[Groups(['order:read', 'delivererReviews', 'order:detail'])]
    private ?User $client = null;

    #[ORM\OneToOne(inversedBy: 'originOrder', cascade: ['persist', 'remove'])]
    #[Groups(['order:read', 'order:detail', 'delivererReviews'])]
    private ?DelivererReview $delivererReview = null;

    #[ORM\OneToMany(mappedBy: 'productOrder', targetEntity: OrderProduct::class)]
    #[Groups(['order:detail'])]
    private Collection $products;

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

    /**
     * @return Collection<int, OrderProduct>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(OrderProduct $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setProductOrder($this);
        }

        return $this;
    }

    public function removeProduct(OrderProduct $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getProductOrder() === $this) {
                $product->setProductOrder(null);
            }
        }

        return $this;
    }
}

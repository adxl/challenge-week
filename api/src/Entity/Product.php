<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['product:read']])]
class Product
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	#[Groups(['product:read'])]
	private ?int $id = null;

	#[ORM\Column(length: 255)]
	#[Groups(['product:read', 'order:detail'])]
	private ?string $name = null;

	#[ORM\Column]
	#[Groups(['product:read'])]
	private ?int $quantity = null;

	#[ORM\Column(type: Types::TEXT)]
	#[Groups(['product:read'])]
	private ?string $description = null;

	#[ORM\Column]
	#[Groups(['product:read', 'order:detail'])]
	private ?float $price = null;

	#[ORM\ManyToOne(inversedBy: 'products')]
	#[Groups(['product:read'])]
	#[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
	private ?ProductType $type = null;

	#[ORM\ManyToOne]
	#[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
	#[Groups(['product:read'])]
	private ?ProductCategory $category = null;

	#[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductReview::class, orphanRemoval: true)]
	private Collection $reviews;

	public function __construct()
	{
		$this->reviews = new ArrayCollection();
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

	public function getQuantity(): ?int
	{
		return $this->quantity;
	}

	public function setQuantity(int $quantity): self
	{
		$this->quantity = $quantity;

		return $this;
	}

	public function getDescription(): ?string
	{
		return $this->description;
	}

	public function setDescription(string $description): self
	{
		$this->description = $description;

		return $this;
	}

	public function getPrice(): ?float
	{
		return $this->price;
	}

	public function setPrice(float $price): self
	{
		$this->price = $price;

		return $this;
	}

	public function getType(): ?ProductType
	{
		return $this->type;
	}

	public function setType(?ProductType $type): self
	{
		$this->type = $type;

		return $this;
	}

	public function getCategory(): ?ProductCategory
	{
		return $this->category;
	}

	public function setCategory(?ProductCategory $category): self
	{
		$this->category = $category;

		return $this;
	}

	/**
	 * @return Collection<int, ProductReview>
	 */
	public function getReviews(): Collection
	{
		return $this->reviews;
	}

	public function addReview(ProductReview $review): self
	{
		if (!$this->reviews->contains($review)) {
			$this->reviews->add($review);
			$review->setProduct($this);
		}

		return $this;
	}

	public function removeReview(ProductReview $review): self
	{
		if ($this->reviews->removeElement($review)) {
			// set the owning side to null (unless already changed)
			if ($review->getProduct() === $this) {
				$review->setProduct(null);
			}
		}

		return $this;
	}
}

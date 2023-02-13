<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProductCategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\Traits\TimestampableTrait;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;

#[ORM\Entity(repositoryClass: ProductCategoryRepository::class)]
#[ApiResource(
  operations: [
    new GetCollection(),
    new Get(),
    new Post(security: 'is_granted("ROLE_ADMIN")'),
    new Patch(security: 'is_granted("ROLE_ADMIN")'),
    new Delete(security: 'is_granted("ROLE_ADMIN")'),
  ],
)]
class ProductCategory
{
	use TimestampableTrait;

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 255)]
	#[Groups(['product:read'])]
	private ?string $name = null;

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
}

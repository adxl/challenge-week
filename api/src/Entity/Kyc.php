<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Traits\TimestampableTrait;
use App\Repository\KycRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\CreateKycController;

#[ORM\Entity(repositoryClass: KycRepository::class)]
#[ApiResource(
  operations: [
    new GetCollection(security: 'is_granted("ROLE_ADMIN")'),
    new Get(security: 'is_granted("ROLE_ADMIN") or user == object.getDeliverer()'),
    new Patch(security: 'is_granted("ROLE_ADMIN") or user == object.getDeliverer()'),
    new Post(controller: CreateKycController::class)
  ],
  normalizationContext: ['groups' => ['kyc:read']]
)]
#[ApiFilter(SearchFilter::class, properties: ['status' => 'exact'])]
class Kyc
{

  use TimestampableTrait;

  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  #[Groups(['kyc:read', 'self'])]
  private ?int $id = null;


  #[ORM\Column(length: 255)]
  #[Groups(['kyc:read', 'self'])]
  private ?string $siret = null;

  #[ORM\Column(length: 255)]
  #[Groups(['kyc:read', 'self'])]
  private ?string $status = null;

  #[ORM\Column(type: Types::TEXT, nullable: true)]
  #[Groups(['kyc:read', 'self'])]
  private ?string $reason = null;

  #[ORM\OneToOne(mappedBy: 'kyc', cascade: ['persist', 'remove'])]
  #[Groups(['kyc:read', 'self'])]
  private ?User $deliverer = null;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getSiret(): ?string
  {
    return $this->siret;
  }

  public function setSiret(string $siret): self
  {
    $this->siret = $siret;

    return $this;
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

  public function getReason(): ?string
  {
    return $this->reason;
  }

  public function setReason(?string $reason): self
  {
    $this->reason = $reason;

    return $this;
  }

  public function getDeliverer(): ?User
  {
    return $this->deliverer;
  }

  public function setDeliverer(?User $deliverer): self
  {
    // unset the owning side of the relation if necessary
    if ($deliverer === null && $this->deliverer !== null) {
      $this->deliverer->setKyc(null);
    }

    // set the owning side of the relation if necessary
    if ($deliverer !== null && $deliverer->getKyc() !== $this) {
      $deliverer->setKyc($this);
    }

    $this->deliverer = $deliverer;

    return $this;
  }
}


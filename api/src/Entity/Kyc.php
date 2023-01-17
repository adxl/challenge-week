<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\KycRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: KycRepository::class)]
#[ApiResource]
class Kyc
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $identity = null;

    #[ORM\Column(length: 255)]
    private ?string $license = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $reason = null;

    #[ORM\OneToOne(mappedBy: 'kyc', cascade: ['persist', 'remove'])]
    private ?User $deliverer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentity(): ?string
    {
        return $this->identity;
    }

    public function setIdentity(string $identity): self
    {
        $this->identity = $identity;

        return $this;
    }

    public function getLicense(): ?string
    {
        return $this->license;
    }

    public function setLicense(string $license): self
    {
        $this->license = $license;

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

    public function setReason(string $reason): self
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

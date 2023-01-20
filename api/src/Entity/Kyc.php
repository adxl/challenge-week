<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\KycRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: KycRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['kyc:read']])]
#[ApiFilter(SearchFilter::class, properties: ['status' => 'exact'])]
class Kyc
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
	#[Groups(['kyc:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
	#[Groups(['kyc:read'])]
    private ?string $siret = null;

    #[ORM\Column(length: 255)]
	#[Groups(['kyc:read'])]
    private ?string $status = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
	#[Groups(['kyc:read'])]
    private ?string $reason = null;

    #[ORM\OneToOne(mappedBy: 'kyc', cascade: ['persist', 'remove'])]
	#[Groups(['kyc:read'])]
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

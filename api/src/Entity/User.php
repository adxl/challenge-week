<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use App\Controller\RegisterController;
use App\Controller\VerifyTokenController;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource(mercure: true, operations: [
    new Get(security: 'is_granted("PUBLIC_ACCESS")'),
    new GetCollection(security: 'is_granted("PUBLIC_ACCESS")'),
    new Post(security: 'is_granted("PUBLIC_ACCESS")', name: 'register', controller: RegisterController::class),
    new Post(security: 'is_granted("PUBLIC_ACCESS")', name: 'verify_token', controller: VerifyTokenController::class),
    new Put(),
    new Patch(),
    new Delete(),
])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $birthday_at = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    private ?string $token = null;

    #[ORM\OneToOne(inversedBy: 'deliverer', cascade: ['persist', 'remove'], )]
    private ?Kyc $kyc = null;

    #[ORM\OneToMany(mappedBy: 'deliverer', targetEntity: Order::class)]
    private Collection $delivererOrders;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Order::class)]
    private Collection $clientOrders;

    public function __construct()
    {
        $this->clientOrders = new ArrayCollection();
        $this->delivererOrders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBirthdayAt(): ?\DateTimeImmutable
    {
        return $this->birthday_at;
    }

    public function setBirthdayAt(\DateTimeImmutable $birthday_at): self
    {
        $this->birthday_at = $birthday_at;

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getKyc(): ?Kyc
    {
        return $this->kyc;
    }

    public function setKyc(?Kyc $kyc): self
    {
        $this->kyc = $kyc;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getDelivererOrders(): Collection
    {
        return $this->delivererOrders;
    }

    public function addDelivererOrder(Order $order): self
    {
        if (!$this->delivererOrders->contains($order)) {
            $this->delivererOrders->add($order);
            $order->setDeliverer($this);
        }

        return $this;
    }

    public function removeDelivererOrder(Order $order): self
    {
        if ($this->delivererOrders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getDeliverer() === $this) {
                $order->setDeliverer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getClientOrders(): Collection
    {
        return $this->clientOrders;
    }

    public function addClientOrder(Order $order): self
    {
        if (!$this->clientOrders->contains($order)) {
            $this->clientOrders->add($order);
            $order->setDeliverer($this);
        }

        return $this;
    }

    public function removeClientOrder(Order $order): self
    {
        if ($this->clientOrders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getDeliverer() === $this) {
                $order->setDeliverer(null);
            }
        }

        return $this;
    }
}

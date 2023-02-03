<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
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
use App\Controller\BanUserController;
use App\Controller\GiveRoleAdminController;
use App\Controller\CheckPasswordController;
use App\Controller\ClientsProfilController;
use App\Controller\DeliverersProfilController;
use App\Controller\RegisterController;
use App\Controller\VerifyTokenController;
use App\Controller\ResetPasswordController;
use App\Controller\SelfAuthController;
use App\Controller\UpdateUserController;
use App\State\UserPasswordHasher;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource(mercure: true, operations: [
  new GetCollection(
    name: "self_auth",
    uriTemplate: '/users/me',
    requirements: [],
    controller: SelfAuthController::class,
  ),
  new GetCollection(
    security: 'is_granted("ROLE_ADMIN")',
    name: "clients_profil",
    uriTemplate: '/users/clients',
    requirements: [],
    controller: ClientsProfilController::class,
  ),
  new GetCollection(
    security: 'is_granted("ROLE_ADMIN")',
    name: "deliverers_profil",
    uriTemplate: '/users/deliverers',
    requirements: [],
    controller: DeliverersProfilController::class,
  ),
  new Get(),
  new GetCollection(),
  new Post(
    security: 'is_granted("PUBLIC_ACCESS")',
    name: 'register',
    processor: UserPasswordHasher::class,
    controller: RegisterController::class,
    denormalizationContext: ["groups" => ["self_register"]]
  ),
  new Post(security: 'is_granted("PUBLIC_ACCESS")', name: 'verify_token', controller: VerifyTokenController::class),
  new Post(security: 'is_granted("PUBLIC_ACCESS")', name: 'reset_password_email', controller: ResetPasswordController::class),
  new Post(
    security: 'user == object',
    uriTemplate: 'users/{id}/password/check',
    controller: CheckPasswordController::class,
    denormalizationContext: ["groups" => ["self_check_password"]]
  ),
  new Post(
    security: 'is_granted("ROLE_ADMIN")',
    uriTemplate: '/users/{id}/ban',
    controller: BanUserController::class,
  ),
  new Post(
    security: 'is_granted("ROLE_ADMIN")',
    uriTemplate: '/users/{id}/role/admin',
    controller: GiveRoleAdminController::class,
  ),
  new Put(processor: UserPasswordHasher::class),
  new Patch(processor: UserPasswordHasher::class, denormalizationContext: ["groups" => ["self_update"]]),
  new Patch(
    security: 'is_granted("PUBLIC_ACCESS")',
    uriTemplate: '/users/reset-password/{token}',
    name: 'reset_password',
    controller: ResetPasswordController::class,
  ),
  new Delete(),
], normalizationContext: ["groups" => ["self", "user:read"]])]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{

  use TimestampableTrait;

  public const STATUS = [
    "INACTIVE" => "INACTIVE",
    "ACTIVE" => "ACTIVE",
    "OPERATIVE" => "OPERATIVE",
    "SUSPENDED" => "SUSPENDED",
    "BANNED" => "BANNED"
  ];

  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  #[Groups(["self", 'kyc:read'])]
  private ?int $id = null;

  #[ORM\Column(length: 180, unique: true)]
  #[Groups(["self", 'delivererReviews', 'self_register'])]
  private ?string $email = null;

  #[ORM\Column]
  #[Groups(["self", 'delivererReviews', 'self_register'])]
  private array $roles = [];

  /**
   * @var string The hashed password
   */
  #[ORM\Column]
  private ?string $password = null;

  #[Assert\NotBlank(groups: ['self_register', 'self_check_password'])]
  #[Groups(['self_register', 'self_update', 'self_check_password'])]
  private ?string $plainPassword = null;

  #[ORM\Column(length: 255)]
  #[Groups(['order:read', 'self', 'delivererReviews', 'order:detail', 'kyc:read', 'self_register', 'self_update'])]
  private ?string $firstname = null;

  #[ORM\Column(length: 255)]
  #[Groups(['order:read', 'self', 'delivererReviews', 'order:detail', 'kyc:read', 'self_register', 'self_update'])]
  private ?string $lastname = null;

  #[ORM\Column(nullable: true)]
  #[Groups(["self", 'self_register', 'self_update'])]
  private ?\DateTimeImmutable $birthdayAt = null;

  #[ORM\Column(length: 255)]
  #[Groups(["self"])]
  private ?string $status = null;

  #[ORM\Column(length: 255)]
  #[Groups(["self", "order:read", "order:detail", 'self_register', 'self_update'])]
  private ?string $address = null;

  #[ORM\Column(length: 255, nullable: true)]
  private ?string $token = null;

	#[ORM\OneToOne(inversedBy: 'deliverer', cascade: ['persist', 'remove'],)]
	#[Groups(["self"])]
	private ?Kyc $kyc = null;

  #[ORM\OneToMany(mappedBy: 'deliverer', targetEntity: Order::class)]
  #[Groups(["self"])]
  private Collection $delivererOrders;

  #[ORM\OneToMany(mappedBy: 'client', targetEntity: Order::class)]
  #[Groups(["self"])]
  private Collection $clientOrders;

  public function __construct()
  {
    $this->clientOrders = new ArrayCollection();
    $this->delivererOrders = new ArrayCollection();
    $this->status = self::STATUS['INACTIVE'];
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

  public function getPlainPassword(): ?string
  {
    return $this->plainPassword;
  }

  public function setPlainPassword(?string $painPassword): self
  {
    $this->plainPassword = $painPassword;

    return $this;
  }

  /**
   * @see UserInterface
   */
  public function eraseCredentials()
  {
    $this->plainPassword = null;
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
    return $this->birthdayAt;
  }

  public function setBirthdayAt(?\DateTimeImmutable $birthdayAt): self
  {
    $this->birthdayAt = $birthdayAt;

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

  public function setToken(?string $token): self
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
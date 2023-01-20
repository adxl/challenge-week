<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\DelivererReview;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

#[AsController]
class DelivererReviewsController extends AbstractController
{
  public function __construct(
    private TokenStorageInterface $tokenStorageInterface,
    private JWTTokenManagerInterface $jwtManager
  ) {
  }

  public function __invoke(ManagerRegistry $doctrine): array
  {
    $token = $this->jwtManager->decode($this->tokenStorageInterface->getToken());

    $em = $doctrine->getManager();
    $user = $em->getRepository(User::class)->findOneBy(['email' => $token["username"]]);

    if (in_array('ROLE_ADMIN', $user->getRoles())) {
      return $em->getRepository(DelivererReview::class)->findAll();
    } elseif (in_array('ROLE_CLIENT', $user->getRoles())) {
      $reviews = array_map(fn ($order) => $order,$user->getClientOrders()->toArray() );
      return $reviews;
    }
  }
}

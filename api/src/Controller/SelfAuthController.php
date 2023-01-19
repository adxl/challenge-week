<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Doctrine\Persistence\ManagerRegistry;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[AsController]
class SelfAuthController extends AbstractController
{
  public function __construct(
    private TokenStorageInterface $tokenStorageInterface,
    private JWTTokenManagerInterface $jwtManager
  ) {
  }

  public function __invoke(ManagerRegistry $doctrine)
  {
    $token = $this->jwtManager->decode($this->tokenStorageInterface->getToken());

    $em = $doctrine->getManager();
    $user = $em->getRepository(User::class)->findOneBy(['email' => $token["username"]]);

    return $user;
  }
}

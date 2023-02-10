<?php

namespace App\Controller;

use App\Entity\Kyc;
use App\Service\TokenGeneration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RequestStack;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[AsController]
class CreateKycController extends AbstractController
{
  public function __construct(
    private RequestStack $requestStack,
    private ManagerRegistry $managerRegistry,
    private TokenStorageInterface $tokenStorageInterface,
    private JWTTokenManagerInterface $jwtManager
  ) {
  }

  public function __invoke(Kyc $kyc, ManagerRegistry $doctrine): Kyc
  {
    $em = $doctrine->getManager();
    $kyc->setStatus("PENDING");
    $em->flush();

    return $kyc;
  }
}
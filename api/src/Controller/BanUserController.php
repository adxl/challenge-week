<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\TokenGeneration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RequestStack;

#[AsController]
class BanUserController extends AbstractController
{
  public function __construct(
    private RequestStack $requestStack,
    private ManagerRegistry $managerRegistry
  ) {
  }

  public function __invoke(User $user, ManagerRegistry $doctrine): User
  {
    $em = $doctrine->getManager();
    $user->setStatus(User::STATUS["BANNED"]);
    $em->flush();

    return $user;
  }
}
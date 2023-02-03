<?php

namespace App\Controller\Order;

use App\Entity\User;
use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

#[AsController]
class GetAllOrderController extends AbstractController
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

      $orders = $em->getRepository(Order::class)->findAll();

      return $orders;
    } elseif (in_array('ROLE_DELIVERER', $user->getRoles()) && $user->getStatus() === User::STATUS["OPERATIVE"]) {

      $orders = $em->getRepository(Order::class)->findBy(['deliverer' => $user, 'status' => 'SHIPPING'], ["createdAt" => 'DESC']);

      if (empty($orders)) {
        $orders = $em->getRepository(Order::class)->findBy(['status' => 'PENDING'], ["createdAt" => 'DESC']);
      }

      return $orders;
    } else {

      $orders = $em->getRepository(Order::class)->findBy(['client' => $user], ["createdAt" => 'DESC']);

      return $orders;
    }
  }
}

<?php

namespace App\Controller\Order;

use App\Entity\User;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\OrderProduct;
use App\Entity\ProductReview;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\JsonResponse;

#[AsController]
class CreateOrderController extends AbstractController
{
  public function __construct(
    private TokenStorageInterface $tokenStorageInterface,
    private JWTTokenManagerInterface $jwtManager,
    private RequestStack $requestStack
  ) {
  }

  public function __invoke(ManagerRegistry $doctrine): JsonResponse
  {
    $token = $this->jwtManager->decode($this->tokenStorageInterface->getToken());

    $em = $doctrine->getManager();
    $user = $em->getRepository(User::class)->findOneBy(['email' => $token["username"]]);

    $productsOrdered = json_decode($this->requestStack->getCurrentRequest()->getContent())->productsOrder;

    $order = new Order();
    $order->setClient($user);
    $order->setStatus("PENDING");
    $em->persist($order);
    $em->flush();
    
    foreach ($productsOrdered as $oneProduct) {
      $product = $em->getRepository(Product::class)->findOneBy(['id' => $oneProduct->id]);

      $productReview = new ProductReview();
      $productReview->setProduct($product);
      $productReview->setOriginOrder($order);

      $orderProduct = new OrderProduct();
      $orderProduct->setProduct($product);
      $orderProduct->setQuantity($oneProduct->quantity);
      $orderProduct->setOriginOrder($order);

      $em->persist($productReview);
      $em->persist($orderProduct);
    }

    $em->flush();

    return $this->json([
      "code" => 200,
      "message" => "Order created"
    ]);
  }
}

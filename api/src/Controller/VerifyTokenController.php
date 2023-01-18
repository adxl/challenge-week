<?php
// api/src/Controller/CreateBookPublication.php
namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

#[AsController]
class VerifyTokenController extends AbstractController
{
    public function __construct(
    ) {}

    #[Route(
        name: 'verify_token',
        path: '/users/verify/{token}',
        methods: ['POST'],
        defaults: [
            '_api_operation_name' => '_api_/users/verify/{token}',
        ],
    )]
    public function __invoke(string $token, ManagerRegistry $doctrine): JsonResponse
    {
      $em = $doctrine->getManager();

      $user = $em->getRepository(User::class)->findOneBy(['token' => $token]);

      if ($user) {
        $user->setToken(null);
        $user->setStatus('ACTIVE');
        $em->flush();
      }
      
      return $this->json([
        "code" => 200,
        "message" => "User verified"
      ]);
    }
}
<?php
// api/src/Controller/CreateBookPublication.php
namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

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
            '_api_resource_class' => User::class,
            '_api_operation_name' => '_api_/users/verify/{token}',
        ],
    )]
    public function __invoke(string $token, ManagerRegistry $doctrine): void
    {
      $em = $doctrine->getManager();

      $user = $em->getRepository(User::class)->findOneBy(['token' => $token]);

      if ($user) {
        $user->setToken(null);
        $user->setStatus('ACTIVE');
        $em->flush();
      }
    }
}
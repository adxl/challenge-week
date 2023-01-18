<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\BlueMailer;
use App\Service\TokenGeneration;

#[AsController]
class ResetPasswordController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
        private ManagerRegistry $managerRegistry
    ) {}

    // TEMPLATE 7
    #[Route(
        name: 'reset_password',
        path: '/users/reset-password/{token}',
        methods: ['PATCH'],
        defaults: [
            '_api_operation_name' => '_api_/users/reset-password/{token}',
        ],
    )]
    public function __invoke(string $token, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        // TODO : Secure if not password in body
        $password = json_decode($this->requestStack->getCurrentRequest()->getContent())->password;

        /** @var User $user */
        if (!$user = $this->managerRegistry->getRepository(User::class)->findOneBy(['token' => $token])) {
            throw $this->createNotFoundException();
        }

        $user->setPassword($passwordHasher->hashPassword($user, $password));
        $user->setToken(null);
        $this->managerRegistry->getManager()->flush();

        return $this->json([
          "code" => 200,
          "message" => "Password changed"
        ]);
    }

    #[Route(
        name: 'reset_password_email',
        path: '/users/reset-password',
        methods: ['POST'],
        defaults: [
            '_api_operation_name' => '_api_/users/reset-password',
        ],
    )]
    public function sendRstPwdMail(ManagerRegistry $doctrine): JsonResponse
    {
        // TODO : Secure if not email in body
        $email = json_decode($this->requestStack->getCurrentRequest()->getContent())->email;

        if (!$user = $this->managerRegistry->getRepository(User::class)->findOneBy(['email' => $email])) {
            throw $this->createNotFoundException();
        }

        $em = $doctrine->getManager();
        $token = TokenGeneration::generateToken();
        $user->setToken($token);
        $em->flush();

        $url = $_ENV["APP_URL"] . '/reset-password/' . $token;

        $mailer = new BlueMailer();
        $mailer->sendEmail($user, 7, [
            'URL' => $url,
            "firstname" => $user->getFirstname(),
        ]);

        return $this->json([
          "code" => 200,
          "message" => "Email sent"
        ]);
    }
}
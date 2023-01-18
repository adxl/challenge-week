<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\MailerService;
use App\Service\TokenGeneration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Doctrine\Persistence\ManagerRegistry;

#[AsController]
class RegisterController extends AbstractController
{
    public function __construct()
    {
    }

    public function __invoke(User $user, ManagerRegistry $doctrine, MailerService $mailer): User
    {
        $em = $doctrine->getManager();
        $token = TokenGeneration::generateToken();
        $user->setToken($token);
        $em->flush();

        $url = $_ENV["APP_URL"] . '/users/verify/' . $token;

        $mailer = new BlueMailer();
        $mailer->sendEmail($user, 6, [
            'URL' => $url,
            "firstname" => $user->getFirstname(),
        ]);

        return $user;
    }
}

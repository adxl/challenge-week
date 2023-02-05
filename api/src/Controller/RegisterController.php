<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\TokenGeneration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[AsController]
class RegisterController extends AbstractController
{
    public function __construct()
    {
    }

    public function __invoke(User $user, ManagerRegistry $doctrine, MailerInterface $mailer): User
    {
        if ($_ENV["APP_STAGE"] === "local") {
          return $user;
        }

        $em = $doctrine->getManager();
        $token = TokenGeneration::generateToken();
        $user->setToken($token);
        $em->flush();

        $url = $_ENV["APP_URL"] . '/users/verify/' . $token;

        $email = (new Email())
            ->from('supp.myschool@outlook.fr')
            ->to($user->getEmail())
            ->subject('Confirmation de votre compte')
            ->html('Pour confirmer votre compte, veuillez cliquer sur le lien suivant : <a href="' . $url . '">Confirmer mon compte</a>');

        $mailer->send($email);

        return $user;
    }
}

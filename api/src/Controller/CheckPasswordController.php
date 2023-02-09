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
use App\Service\TokenGeneration;

#[AsController]
class CheckPasswordController extends AbstractController
{
	public function __construct(
		private RequestStack $requestStack,
		private ManagerRegistry $managerRegistry
	) {
	}


	public function __invoke(User $user, UserPasswordHasherInterface $passwordHasher): JsonResponse
	{
		$plainPassword = $user->getPlainPassword();

		if (!$plainPassword) {
			return $this->json([
				"code" => 400,
				"message" => "Le mot de passe actuel est incorrect"
			]);
		}

		if (!$passwordHasher->isPasswordValid($user, $plainPassword)) {
			return $this->json([
				"code" => 400,
				"message" => "Le mot de passe actuel est incorrect"
			]);
		}

		return $this->json([
			"code" => 200,
			"message" => "Mot de passe correct",
		]);
	}
}
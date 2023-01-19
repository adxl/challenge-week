<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Doctrine\Persistence\ManagerRegistry;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[AsController]
class DeliverersProfilController extends AbstractController
{
	public function __construct(private JWTTokenManagerInterface $jwtManager)
	{
	}

	public function __invoke(ManagerRegistry $doctrine)
	{
		$em = $doctrine->getManager();
		$users = $em->getRepository(User::class)->findAll();
		return array_filter($users, fn ($user) => in_array("ROLE_DELIVERER", $user->getRoles()));
	}
}
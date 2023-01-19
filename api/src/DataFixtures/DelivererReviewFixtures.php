<?php

namespace App\DataFixtures;

use App\Entity\Order;
use App\Entity\DelivererReview;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class DelivererReviewFixtures extends Fixture implements DependentFixtureInterface
{

	public function load(ObjectManager $manager): void
	{
		$faker = \Faker\Factory::create('fr_FR');
		$orders = $manager->getRepository(Order::class)->findByStatus(
			[OrderFixtures::DONE]
		);

		foreach ($orders as $order) {

			$delivererReview = new DelivererReview();
			$delivererReview->setOrder($order);
			$delivererReview->setComment($faker->sentence(10));
			$delivererReview->setRating($faker->numberBetween(0, 5));
			$manager->persist($delivererReview);
		}

		$manager->flush();
	}
	public function getDependencies()
	{
		return [
			OrderFixtures::class,
		];
	}
}
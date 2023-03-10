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

      if (
        $order->getClient() === $this->getReference("client_3")
        && $order->getDeliverer() === $this->getReference('deliverer_1')
      ) {
        continue;
      }

      $delivererReview = new DelivererReview();
      $delivererReview->setOriginOrder($order);
      $delivererReview->setComment($faker->sentence(10));
      if (in_array($order->getId(), [9, 10, 11]))
        $delivererReview->setRating(0);
      else
        $delivererReview->setRating($faker->numberBetween(1, 5));
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
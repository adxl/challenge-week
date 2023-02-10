<?php

namespace App\DataFixtures;

use App\Entity\OrderProduct;
use App\Entity\ProductReview;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProductReviewFixtures extends Fixture implements DependentFixtureInterface
{

  public function load(ObjectManager $manager): void
  {
    $faker = \Faker\Factory::create('fr_FR');
    $orderProducts = $manager->getRepository(OrderProduct::class)->findAll();

    foreach ($orderProducts as $orderProduct) {

      $productReview = new ProductReview();
      $productReview->setProduct($orderProduct->getProduct());
      $productReview->setOriginOrder($orderProduct->getOriginOrder());
      $productReview->setRating($faker->randomElement([$faker->boolean, NULL]));
      $manager->persist($productReview);
    }

    $manager->flush();
  }

  public function getDependencies()
  {
    return [
      OrderProductFixtures::class,
    ];
  }
}

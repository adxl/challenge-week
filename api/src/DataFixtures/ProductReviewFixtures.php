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
    $orderProducts = $manager->getRepository(OrderProduct::class)->findByOrderByStatus(
      [OrderFixtures::DONE]
    );

    foreach($orderProducts as $orderProduct) {
      
      $productReview = new ProductReview();
      $productReview->setProduct($orderProduct->getProduct());
      $productReview->setOrder($orderProduct->getOrder());
      $productReview->setRating($faker->boolean);
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

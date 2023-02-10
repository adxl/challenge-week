<?php

namespace App\DataFixtures;

use App\Entity\Order;
use App\Entity\OrderProduct;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class OrderProductFixtures extends Fixture implements DependentFixtureInterface
{

  public function load(ObjectManager $manager): void
  {
    $faker = \Faker\Factory::create('fr_FR');
    $orders = $manager->getRepository(Order::class)->findAll();

    foreach ($orders as $order) {
      $productIds = [1, 2, 3, 4, 5];

      for ($i = 1; $i <= $faker->numberBetween(1, 5); $i++) {
        $productNumber = $faker->randomElement($productIds);
        $productIds = array_diff($productIds, [$productNumber]);

        $orderProduct = new OrderProduct();
        $orderProduct->setOriginOrder($order);
        $orderProduct->setProduct($this->getReference('product_' . $productNumber));
        $orderProduct->setQuantity($faker->numberBetween(1, 10));
        $manager->persist($orderProduct);
      }
    }

    $manager->flush();
  }

  public function getDependencies()
  {
    return [
      OrderFixtures::class,
      ProductFixtures::class,
    ];
  }
}

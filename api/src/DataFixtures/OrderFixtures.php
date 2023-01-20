<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Order;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
class OrderFixtures extends Fixture implements DependentFixtureInterface
{

  public const PENDING = "PENDING";
  public const SHIPPING = "SHIPPING";
  public const DONE = "DONE";
  public function load(ObjectManager $manager): void
  {

    // C1
    $order = new Order();
    $order->setStatus(self::PENDING);
    $order->setClient($this->getReference('client_1'));
    $order->setDeliverer(NULL);
    $manager->persist($order);
    $this->addReference('order_1', $order);

    $order = new Order();
    $order->setStatus(self::SHIPPING);
    $order->setClient($this->getReference('client_1'));
    $order->setDeliverer($this->getReference('deliverer_1'));
    $manager->persist($order);
    $this->addReference('order_2', $order);

    // C2
    $order = new Order();
    $order->setStatus(self::PENDING);
    $order->setClient($this->getReference('client_2'));
    $order->setDeliverer(NULL);
    $manager->persist($order);
    $this->addReference('order_3', $order);

    $order = new Order();
    $order->setStatus(self::PENDING);
    $order->setClient($this->getReference('client_2'));
    $order->setDeliverer(NULL);
    $manager->persist($order);
    $this->addReference('order_4', $order);

    // C3
    $order = new Order();
    $order->setStatus(self::DONE);
    $order->setClient($this->getReference('client_1'));
    $order->setDeliverer($this->getReference('deliverer_1'));
    $manager->persist($order);
    $this->addReference('order_5', $order);

    $order = new Order();
    $order->setStatus(self::DONE);
    $order->setClient($this->getReference('client_3'));
    $order->setDeliverer($this->getReference('deliverer_2'));
    $manager->persist($order);
    $this->addReference('order_6', $order);

    $order = new Order();
    $order->setStatus(self::DONE);
    $order->setClient($this->getReference('client_3'));
    $order->setDeliverer($this->getReference('deliverer_2'));
    $manager->persist($order);
    $this->addReference('order_7', $order);

    $manager->flush();
  }
  public function getDependencies()
  {
    return [
      UserFixtures::class,
    ];
  }
  
}

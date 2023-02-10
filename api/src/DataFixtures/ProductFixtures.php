<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;
use App\Entity\ProductCategory;
use Faker;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
  public function load(ObjectManager $manager): void
  {
    $faker = Faker\Factory::create("fr-FR");
    $categories = $manager->getRepository(ProductCategory::class)->findAll();

    $product = new Product();
    $product->setName('Uranium 92');
    $product->setPrice(12000);
    $product->setQuantity(100);
    $product->setCategory($faker->randomElement($categories));
    $product->setType($this->getReference(ProductTypeFixtures::COMPRIME));
    $product->setDescription($faker->sentence);
    $this->addReference('product_1', $product);
    $manager->persist($product);

    $product = new Product();
    $product->setName("Cyanure de sodium");
    $product->setPrice(650);
    $product->setQuantity(150);
    $product->setCategory($faker->randomElement($categories));
    $product->setType($this->getReference(ProductTypeFixtures::LIQUIDE));
    $product->setDescription($faker->sentence);
    $this->addReference('product_2', $product);
    $manager->persist($product);

    $product = new Product();
    $product->setName('Acide chlorhydrique');
    $product->setPrice(129.99);
    $product->setQuantity(500);
    $product->setCategory($faker->randomElement($categories));
    $product->setType($this->getReference(ProductTypeFixtures::COMPRIME));
    $product->setDescription($faker->sentence);
    $this->addReference('product_3', $product);
    $manager->persist($product);

    $product = new Product();
    $product->setName('Dioxyde de soufre');
    $product->setPrice(899.99);
    $product->setQuantity(1000);
    $product->setCategory($faker->randomElement($categories));
    $product->setType($this->getReference(ProductTypeFixtures::GELLULE));
    $product->setDescription($faker->sentence);
    $this->addReference('product_4', $product);
    $manager->persist($product);

    $product = new Product();
    $product->setName('Phosphore rouge');
    $product->setPrice(44.25);
    $product->setQuantity(1000);
    $product->setCategory($faker->randomElement($categories));
    $product->setType($this->getReference(ProductTypeFixtures::LIQUIDE));
    $product->setDescription($faker->sentence);
    $this->addReference('product_5', $product);
    $manager->persist($product);

    for ($i = 1; $i < 20; $i++) {
      $product = new Product();
      $product->setName($faker->sentence(3, false));
      $product->setPrice($faker->randomFloat(2, 10, 100));
      $product->setQuantity($faker->randomNumber(3, true));
      $product->setCategory($faker->randomElement($categories));
      $product->setType($this->getReference($faker->randomElement([ProductTypeFixtures::COMPRIME, ProductTypeFixtures::LIQUIDE, ProductTypeFixtures::GELLULE])));
      $product->setDescription($faker->sentence);
      $manager->persist($product);
      $this->addReference('product_' . ($i + 5), $product);
    }

    $manager->flush();
  }

  public function getDependencies()
  {
    return [
      ProductTypeFixtures::class,
      ProductCategoryFixtures::class,
    ];
  }
}

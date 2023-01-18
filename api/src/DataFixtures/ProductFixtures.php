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
    $product->setName('Pastraweed');
    $product->setPrice(35);
    $product->setQuantity(100);
    $product->setCategory($faker->randomElement($categories));
    $product->setType($this->getReference(ProductTypeFixtures::BRUT));
    $product->setDescription('Family Business Edition');
    $this->addReference('product_1', $product);
    $manager->persist($product);

    $product = new Product();
    $product->setName('Beuh Blanc Rouge');
    $product->setPrice(55.4);
    $product->setQuantity(150);
    $product->setCategory($faker->randomElement($categories));
    $product->setType($this->getReference(ProductTypeFixtures::LIQUIDE));
    $product->setDescription('La sauce du chef');
    $this->addReference('product_2', $product);
    $manager->persist($product);

    $product = new Product();
    $product->setName('GreenHigh');
    $product->setPrice(129.99);
    $product->setQuantity(50);
    $product->setCategory($faker->randomElement($categories));
    $product->setType($this->getReference(ProductTypeFixtures::BRUT));
    $product->setDescription('Beuh Blanc Rouge x Snoop Dogg');
    $this->addReference('product_3', $product);
    $manager->persist($product);

    $product = new Product();
    $product->setName('Mont Everest');
    $product->setPrice(89.99);
    $product->setQuantity(1000);
    $product->setCategory($faker->randomElement($categories));
    $product->setType($this->getReference(ProductTypeFixtures::GELLULE));
    $product->setDescription('Drogue du 7ème ciel');
    $this->addReference('product_4', $product);
    $manager->persist($product);

    $product = new Product();
    $product->setName('Purple Drank');
    $product->setPrice(44.25);
    $product->setQuantity(1000);
    $product->setCategory($faker->randomElement($categories));
    $product->setType($this->getReference(ProductTypeFixtures::LIQUIDE));
    $product->setDescription("C'est de la bonne gros !");
    $this->addReference('product_5', $product);
    $manager->persist($product);

    for($i = 1; $i < 20; $i++) {
      $product = new Product();
      $product->setName($faker->word);
      $product->setPrice($faker->randomFloat(2, 10, 100));
      $product->setQuantity($faker->randomNumber(3));
      $product->setCategory($faker->randomElement($categories));
      $product->setType($this->getReference($faker->randomElement([ProductTypeFixtures::BRUT, ProductTypeFixtures::LIQUIDE, ProductTypeFixtures::GELLULE])));
      $product->setDescription($faker->sentence);
      $manager->persist($product);  
      $this->addReference('product_'.($i+5), $product);

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

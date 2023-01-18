<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\ProductCategory;
class ProductCategoryFixtures extends Fixture
{
  public function load(ObjectManager $manager): void
  {

    // ADMIN

    $cat = new ProductCategory();
    $cat->setName('Euphorisants');
    $manager->persist($cat);

    $cat = new ProductCategory();
    $cat->setName('Hallucinogéne');
    $manager->persist($cat);

    $cat = new ProductCategory();
    $cat->setName('Enivrant');
    $manager->persist($cat);

    $cat = new ProductCategory();
    $cat->setName('Hypnotique');
    $manager->persist($cat);

    $cat = new ProductCategory();
    $cat->setName('Stimulant');
    $manager->persist($cat);

    $manager->flush();

  }
}

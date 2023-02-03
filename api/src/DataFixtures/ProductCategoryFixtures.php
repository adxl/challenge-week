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
    $cat->setName('Énergisant');
    $manager->persist($cat);

    $cat = new ProductCategory();
    $cat->setName('Vitamine');
    $manager->persist($cat);

    $cat = new ProductCategory();
    $cat->setName('Complément');
    $manager->persist($cat);

    $cat = new ProductCategory();
    $cat->setName('Calmant');
    $manager->persist($cat);

    $cat = new ProductCategory();
    $cat->setName('Stimulant');
    $manager->persist($cat);

    $manager->flush();
  }
}

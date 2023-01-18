<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\ProductType;
class ProductTypeFixtures extends Fixture
{

  public const LIQUIDE = 'LIQUIDE';
  public const BRUT = 'BRUT';
  public const GELLULE = 'GELLULE';

  public function load(ObjectManager $manager): void
  {

    // ADMIN

    $type = new ProductType();

    $type->setName('Liquide');
    $type->setLabel('L');
    $type->setUnit(1);
    $manager->persist($type);
    $this->addReference(self::LIQUIDE, $type);


    $type = new ProductType();

    $type->setName('Brut');
    $type->setLabel('MG');
    $type->setUnit(10);
    $manager->persist($type);
    $this->addReference(self::BRUT, $type);

    $type = new ProductType();

    $type->setName('Gellule');
    $type->setLabel('unité');
    $type->setUnit(5);
    $manager->persist($type);
    $this->addReference(self::GELLULE, $type);

    $manager->flush();

  }
}

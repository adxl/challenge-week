<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use \DateTimeImmutable;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;
use App\Entity\User;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
	private UserPasswordHasherInterface $hasher;

	public const ROLE_CLIENT = ["ROLE_CLIENT"];
	public const ROLE_ADMIN = ["ROLE_ADMIN"];
	public const ROLE_DELIVERER = ["ROLE_DELIVERER"];
	public const INACTIVE = "INACTIVE";
	public const ACTIVE = "ACTIVE";
	public const OPERATIVE = "OPERATIVE";

	public function __construct(UserPasswordHasherInterface $hasher)
	{
		$this->hasher = $hasher;
	}
	public function load(ObjectManager $manager): void
	{
		$faker = Faker\Factory::create("fr-FR");

		// ADMIN
		$birthdateInterval = $faker->dateTimeBetween("-50 years", '-18 years');

		$admin = new User();
		$password = $this->hasher->hashPassword($admin, 'esgi');
		$admin->setFirstname('Sami');
		$admin->setLastname('Zerrai');
		$admin->setEmail('sami@esgi.fr');
		$admin->setPassword($password);
		$admin->setRoles(self::ROLE_ADMIN);
		$admin->setStatus(self::ACTIVE);
		$admin->setBirthdayAt(DateTimeImmutable::createFromMutable($birthdateInterval));
		$admin->setAddress($faker->address());
		$manager->persist($admin);

    $admin = new User();
    $password = $this->hasher->hashPassword($admin, 'esgi');
    $admin->setFirstname('Thomas');
    $admin->setLastname('Geoffron');
    $admin->setEmail('thomas@esgi.fr');
    $admin->setPassword($password);
    $admin->setRoles(self::ROLE_ADMIN);
    $admin->setStatus(self::ACTIVE);
    $admin->setBirthdayAt(DateTimeImmutable::createFromMutable($birthdateInterval));
    $admin->setAddress($faker->address());
    $manager->persist($admin);

		$admin = new User();
		$password = $this->hasher->hashPassword($admin, 'esgi');
		$admin->setFirstname('Adel');
		$admin->setLastname('Senhadji');
		$admin->setEmail('adel@esgi.fr');
		$admin->setPassword($password);
		$admin->setRoles(self::ROLE_ADMIN);
		$admin->setStatus(self::ACTIVE);
		$admin->setBirthdayAt(DateTimeImmutable::createFromMutable($birthdateInterval));
		$admin->setAddress($faker->address());
		$manager->persist($admin);

		$admin = new User();
		$password = $this->hasher->hashPassword($admin, 'esgi');
		$admin->setFirstname('Coraline');
		$admin->setLastname('Esedji');
		$admin->setEmail('coraline@esgi.fr');
		$admin->setPassword($password);
		$admin->setRoles(self::ROLE_ADMIN);
		$admin->setStatus(self::ACTIVE);
		$admin->setBirthdayAt(DateTimeImmutable::createFromMutable($birthdateInterval));
		$admin->setAddress($faker->address());
		$manager->persist($admin);

		// USER
		for ($i = 1; $i <= 5; $i++) {
			$birthdateInterval = $faker->dateTimeBetween("-50 years", '-18 years');
			$user = new User();
			$user
				->setFirstname($faker->firstName())
				->setLastname($faker->lastName())
				->setEmail("client_" . $i . "@esgi.fr")
				->setPassword($this->hasher->hashPassword($user, 'esgi'))
				->setStatus(self::ACTIVE)
				->setRoles(self::ROLE_CLIENT)
				->setAddress($faker->address())
				->setBirthdayAt(DateTimeImmutable::createFromMutable($birthdateInterval));

			$manager->persist($user);
			$this->addReference('client_' . $i, $user);
		}

		// DELIVERER
		for ($i = 1; $i <= 4; $i++) {
			$birthdateInterval = $faker->dateTimeBetween("-50 years", '-18 years');
			$user = new User();
			$user
				->setFirstname($faker->firstName())
				->setLastname($faker->lastName())
				->setEmail("deliverer_" . $i . "@esgi.fr")
				->setPassword($this->hasher->hashPassword($user, 'esgi'))
				->setRoles(self::ROLE_DELIVERER)
				->setStatus(self::OPERATIVE)
				->setAddress($faker->address())
				->setKyc($this->getReference(KycFixtures::KYC_VALIDATED . '_' . $i))
				->setBirthdayAt(DateTimeImmutable::createFromMutable($birthdateInterval));

			$manager->persist($user);

			$this->addReference('deliverer_' . $i, $user);
		}

		$user = new User();
		$user
			->setFirstname($faker->firstName())
			->setLastname($faker->lastName())
			->setEmail("deliverer_" . $i . "@esgi.fr")
			->setPassword($this->hasher->hashPassword($user, 'esgi'))
			->setRoles(self::ROLE_DELIVERER)
			->setStatus(self::ACTIVE)
			->setAddress($faker->address())
			->setKyc($this->getReference(KycFixtures::KYC_REFUSED))
			->setBirthdayAt(DateTimeImmutable::createFromMutable($birthdateInterval));

		$manager->persist($user);

		$i = $i + 1;

		$user = new User();
		$user
			->setFirstname($faker->firstName())
			->setLastname($faker->lastName())
			->setEmail("deliverer_" . $i . "@esgi.fr")
			->setPassword($this->hasher->hashPassword($user, 'esgi'))
			->setRoles(self::ROLE_DELIVERER)
			->setStatus(self::ACTIVE)
			->setAddress($faker->address())
			->setKyc($this->getReference(KycFixtures::KYC_PENDING))
			->setBirthdayAt(DateTimeImmutable::createFromMutable($birthdateInterval));
		$manager->persist($user);

		$manager->flush();
	}

	public function getDependencies()
	{
		return [
			KycFixtures::class,
		];
	}
}
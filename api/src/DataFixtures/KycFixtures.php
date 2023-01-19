<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Kyc;
use Symfony\Component\Console\Output\ConsoleOutput;

class KycFixtures extends Fixture
{

    public const KYC_PENDING = "KYC_PENDING";
    public const KYC_VALIDATED = "KYC_VALIDATED";
    public const KYC_REFUSED = "KYC_REFUSED";

    public function load(ObjectManager $manager): void
    {

        $kyc = new Kyc();
        $kyc->setReason(NULL);
        $kyc->setStatus('PENDING');
        $kyc->setIdentity('placeholder.png');
        $kyc->setLicense('placeholder.png');
        $manager->persist($kyc);
        $this->addReference(self::KYC_PENDING, $kyc);

        $kyc = new Kyc();
        $kyc->setReason("La photo de l'identité n'est pas lisible");
        $kyc->setStatus('REFUSED');
        $kyc->setIdentity('placeholder.png');
        $kyc->setLicense('placeholder.png');
        $manager->persist($kyc);
        $this->addReference(self::KYC_REFUSED, $kyc);

        for($i = 1; $i <= 4; $i++) {
          $kyc = new Kyc();
          $kyc->setReason(NULL);
          $kyc->setStatus('VALIDATED');
          $kyc->setIdentity('placeholder.png');
          $kyc->setLicense('placeholder.png');
          $manager->persist($kyc);
          $this->addReference(self::KYC_VALIDATED . '_' .$i, $kyc);
        }

        $manager->flush();
    }

}

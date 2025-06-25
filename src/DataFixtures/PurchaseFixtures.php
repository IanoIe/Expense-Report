<?php

namespace App\DataFixtures;

use App\Entity\Purchase;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PurchaseFixtures extends Fixture implements DependentFixtureInterface
{
    public const CAT_PURCHASE = 'CAT_JOUETS';
    public function load(ObjectManager $manager): void
    {
        $purchase = new Purchase();
        $purchase->setStoreName('Auchan');
        $purchase->setDate(new \DateTime('now'));

        $purchase->setUser($this->getReference(UserFixtures::CAT_USER, User::class));

        $manager->persist($purchase);
         $this->addReference(self::CAT_PURCHASE, $purchase);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}

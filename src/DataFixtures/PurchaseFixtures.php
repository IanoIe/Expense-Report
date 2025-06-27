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
    public const CAT_ELECLERC = 'CAT_ELECLERC';
    public const CAT_CARREFOUR = 'CAT_CARREFOUR';
    public function load(ObjectManager $manager): void
    {
        $purchase = new Purchase();
        $purchase->setStoreName('Auchan');
        $purchase->setDate(new \DateTime('now'));
        $purchase->setUser($this->getReference(UserFixtures::CAT_USER, User::class));
        $manager->persist($purchase);
        $this->addReference(self::CAT_PURCHASE, $purchase);

        $purchase = new Purchase();
        $purchase->setStoreName('E.Leclerc');
        $purchase->setDate(new \DateTime('now'));
        $purchase->setUser($this->getReference(UserFixtures::CAT_USER, User::class));
        $manager->persist($purchase);
        $this->addReference(self::CAT_ELECLERC, $purchase);

        $purchase = new Purchase();
        $purchase->setStoreName('Carrefour');
        $purchase->setDate(new \DateTime('now'));
        $purchase->setUser($this->getReference(UserFixtures::CAT_USER, User::class));
        $manager->persist($purchase);
        $this->addReference(self::CAT_CARREFOUR, $purchase);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}

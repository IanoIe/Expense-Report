<?php

namespace App\DataFixtures;

use App\Entity\Purchase;
use App\Entity\PurchaseItem;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PurchaseItemFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        $purchaseItem = new PurchaseItem();
        $purchaseItem->setProductName('AuchanAOP Champagne 75cl');
        $purchaseItem->setUnitPrice(10.50);
        $purchaseItem->setQuantity(2);
        $purchaseItem->setTotalPrice(21);

        $purchaseItem->setPurchase($this->getReference(PurchaseFixtures::CAT_PURCHASE, Purchase::class));

        $manager->persist($purchaseItem);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PurchaseFixtures::class,
        ];
    }
}

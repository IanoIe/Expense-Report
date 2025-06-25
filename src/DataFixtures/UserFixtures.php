<?php


namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    public const CAT_USER = 'CAT_JOUETS';
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('Jean Pierre');
        $user->setEmail('jean@hotmail.com');
        $user->setPassword('123');
        $user->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);

        $this->addReference(self::CAT_USER, $user);
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['user_group'];
    }
}

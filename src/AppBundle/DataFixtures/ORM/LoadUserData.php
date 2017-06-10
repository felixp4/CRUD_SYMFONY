<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $userAdmin = new User();
        $userAdmin->setUsername('admin');
        $userAdmin->setPassword('kitten');
        $userAdmin->setEmail('admin@example.com');

        $userRyan = new User();
        $userRyan->setUsername('ryan');
        $userRyan->setPassword('ryanpass');
        $userRyan->setEmail('ryan@example.com');

        $manager->persist($userAdmin);
        $manager->persist($userRyan);
        $manager->flush();
    }
}


<?php

namespace App\DataFixtures;

use App\Entity\Group;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class GroupFixture extends Fixture
{
    public const GROUP_1 = 'group 1';
    public const GROUP_2 = 'group 2';

    public function load(ObjectManager $manager)
    {
        $group1 = new Group();

        $group1->setTitle('jumps');
        $manager->persist($group1);
        $this->addReference(self::GROUP_1, $group1);

        $group2 = new Group();
        $group2->setTitle('grabs');
        $manager->persist($group2);
        $this->addReference(self::GROUP_2, $group2);
        $manager->flush();
    }
}

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
    public const GROUP_3 = 'group 3';
    public const GROUP_4 = 'group 4';
    public const GROUP_5 = 'group 5';
    public const GROUP_6 = 'group 6';

    public function load(ObjectManager $manager)
    {
        $group1 = new Group();

        $group1->setTitle('Jumps');
        $manager->persist($group1);
        $this->addReference(self::GROUP_1, $group1);

        $group2 = new Group();
        $group2->setTitle('Grabs');
        $manager->persist($group2);
        $this->addReference(self::GROUP_2, $group2);

        $group3 = new Group();
        $group3->setTitle('Straight airs');
        $manager->persist($group3);
        $this->addReference(self::GROUP_3, $group3);

        $group4 = new Group();
        $group4->setTitle('Spins');
        $manager->persist($group4);
        $this->addReference(self::GROUP_4, $group4);

        $group5 = new Group();
        $group5->setTitle('Slides');
        $manager->persist($group5);
        $this->addReference(self::GROUP_5, $group5);

        $group6 = new Group();
        $group6->setTitle('Stalls');
        $manager->persist($group6);
        $this->addReference(self::GROUP_6, $group6);
        
        $manager->flush();
    }
}

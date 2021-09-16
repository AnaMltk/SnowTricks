<?php

namespace App\DataFixtures;

use App\Entity\Figure;
use App\DataFixtures\UserFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class FigureFixture extends Fixture implements DependentFixtureInterface
{
    public const FIGURE_1 = 'figure 1';
    public const FIGURE_2 = 'figure 2';
    public const FIGURE_3 = 'figure 3';
    public const FIGURE_4 = 'figure 4';
    public function load(ObjectManager $manager)
    {
         $figure1 = new Figure();
         $figure1->setName('figure 1');
         $figure1->setDescription('description 1');
         $figure1->setUser($this->getReference(UserFixtures::USER_ADMIN));
         $this->addReference(self::FIGURE_1, $figure1);
         $figure1->setCreationDate(new \DateTime());
         $figure1->setModificationDate(new \DateTime());
         $manager->persist($figure1);

         $figure2 = new Figure();
         $figure2->setName('figure 2');
         $figure2->setDescription('description 2');
         $figure2->setUser($this->getReference(UserFixtures::USER_ADMIN));
         $this->addReference(self::FIGURE_2, $figure2);
         $figure2->setCreationDate(new \DateTime());
         $figure2->setModificationDate(new \DateTime());
         $manager->persist($figure2);

         $figure3 = new Figure();
         $figure3->setName('figure 3');
         $figure3->setDescription('description 3');
         $figure3->setUser($this->getReference(UserFixtures::USER_ADMIN));
         $this->addReference(self::FIGURE_3, $figure3);
         $figure3->setCreationDate(new \DateTime());
         $figure3->setModificationDate(new \DateTime());
         $manager->persist($figure3);

         $figure4 = new Figure();
         $figure4->setName('figure 4');
         $figure4->setDescription('description 4');
         $figure4->setUser($this->getReference(UserFixtures::USER_ADMIN));
         $this->addReference(self::FIGURE_4, $figure4);
         $figure4->setCreationDate(new \DateTime());
         $figure4->setModificationDate(new \DateTime());
         $manager->persist($figure4);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}

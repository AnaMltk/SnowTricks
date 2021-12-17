<?php

namespace App\DataFixtures;

use App\Entity\Figure;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\GroupFixture;
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
        $figure1->setName('Ollie');
        $figure1->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sit amet venenatis lacus, in aliquet eros. Aenean fermentum porttitor mi vitae egestas. Vestibulum eget pulvinar orci. Fusce laoreet lobortis augue, at viverra nisl vulputate quis. Nam dapibus, urna et congue auctor, ante justo sodales ipsum, in placerat tellus arcu sit amet orci. Etiam vulputate laoreet ipsum, non molestie turpis accumsan blandit. Pellentesque nisl orci, varius in efficitur a, dapibus nec orci. Suspendisse rhoncus, velit sed semper egestas, leo libero ornare nulla, non tempor massa massa nec tortor. Quisque fringilla at orci at vehicula. Sed vel volutpat libero. Proin justo magna, aliquet id hendrerit id, hendrerit sit amet erat. Fusce ac arcu at arcu finibus pulvinar ac sit amet elit. Pellentesque vel nunc vitae augue ullamcorper semper a vitae orci. Fusce dictum bibendum tempor.');
        $figure1->setUser($this->getReference(UserFixtures::USER_ADMIN));
        $this->addReference(self::FIGURE_1, $figure1);
        $figure1->setCreationDate(new \DateTime());
        $figure1->setModificationDate(new \DateTime());
        $figure1->setGroup($this->getReference(GroupFixture::GROUP_1));
        $manager->persist($figure1);

        $figure2 = new Figure();
        $figure2->setName('Nollie');
        $figure2->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sit amet venenatis lacus, in aliquet eros. Aenean fermentum porttitor mi vitae egestas. Vestibulum eget pulvinar orci. Fusce laoreet lobortis augue, at viverra nisl vulputate quis. Nam dapibus, urna et congue auctor, ante justo sodales ipsum, in placerat tellus arcu sit amet orci. Etiam vulputate laoreet ipsum, non molestie turpis accumsan blandit. Pellentesque nisl orci, varius in efficitur a, dapibus nec orci. Suspendisse rhoncus, velit sed semper egestas, leo libero ornare nulla, non tempor massa massa nec tortor. Quisque fringilla at orci at vehicula. Sed vel volutpat libero. Proin justo magna, aliquet id hendrerit id, hendrerit sit amet erat. Fusce ac arcu at arcu finibus pulvinar ac sit amet elit. Pellentesque vel nunc vitae augue ullamcorper semper a vitae orci. Fusce dictum bibendum tempor.');
        $figure2->setUser($this->getReference(UserFixtures::USER_ADMIN));
        $this->addReference(self::FIGURE_2, $figure2);
        $figure2->setCreationDate(new \DateTime());
        $figure2->setModificationDate(new \DateTime());
        $figure2->setGroup($this->getReference(GroupFixture::GROUP_1));
        $manager->persist($figure2);

        $figure3 = new Figure();
        $figure3->setName('Melon');
        $figure3->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sit amet venenatis lacus, in aliquet eros. Aenean fermentum porttitor mi vitae egestas. Vestibulum eget pulvinar orci. Fusce laoreet lobortis augue, at viverra nisl vulputate quis. Nam dapibus, urna et congue auctor, ante justo sodales ipsum, in placerat tellus arcu sit amet orci. Etiam vulputate laoreet ipsum, non molestie turpis accumsan blandit. Pellentesque nisl orci, varius in efficitur a, dapibus nec orci. Suspendisse rhoncus, velit sed semper egestas, leo libero ornare nulla, non tempor massa massa nec tortor. Quisque fringilla at orci at vehicula. Sed vel volutpat libero. Proin justo magna, aliquet id hendrerit id, hendrerit sit amet erat. Fusce ac arcu at arcu finibus pulvinar ac sit amet elit. Pellentesque vel nunc vitae augue ullamcorper semper a vitae orci. Fusce dictum bibendum tempor.');
        $figure3->setUser($this->getReference(UserFixtures::USER_ADMIN));
        $this->addReference(self::FIGURE_3, $figure3);
        $figure3->setCreationDate(new \DateTime());
        $figure3->setModificationDate(new \DateTime());
        $figure3->setGroup($this->getReference(GroupFixture::GROUP_2));
        $manager->persist($figure3);

        $figure4 = new Figure();
        $figure4->setName('Indy');
        $figure4->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sit amet venenatis lacus, in aliquet eros. Aenean fermentum porttitor mi vitae egestas. Vestibulum eget pulvinar orci. Fusce laoreet lobortis augue, at viverra nisl vulputate quis. Nam dapibus, urna et congue auctor, ante justo sodales ipsum, in placerat tellus arcu sit amet orci. Etiam vulputate laoreet ipsum, non molestie turpis accumsan blandit. Pellentesque nisl orci, varius in efficitur a, dapibus nec orci. Suspendisse rhoncus, velit sed semper egestas, leo libero ornare nulla, non tempor massa massa nec tortor. Quisque fringilla at orci at vehicula. Sed vel volutpat libero. Proin justo magna, aliquet id hendrerit id, hendrerit sit amet erat. Fusce ac arcu at arcu finibus pulvinar ac sit amet elit. Pellentesque vel nunc vitae augue ullamcorper semper a vitae orci. Fusce dictum bibendum tempor.');
        $figure4->setUser($this->getReference(UserFixtures::USER_ADMIN));
        $this->addReference(self::FIGURE_4, $figure4);
        $figure4->setCreationDate(new \DateTime());
        $figure4->setModificationDate(new \DateTime());
        $figure4->setGroup($this->getReference(GroupFixture::GROUP_2));
        $manager->persist($figure4);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class, GroupFixture::class
        ];
    }
}

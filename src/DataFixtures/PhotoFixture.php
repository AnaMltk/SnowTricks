<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Photo;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PhotoFixture extends Fixture implements DependentFixtureInterface
{
    
    public function load(ObjectManager $manager)
    {
        $photo1 = new Photo();
        $photo1->setPath('ollie.jpg');
        $photo1->setAlt('img1');
        $photo1->setCreationDate(new DateTime());
        $photo1->setFigure($this->getReference(FigureFixture::FIGURE_1));
        $manager->persist($photo1);

        $photo2 = new Photo();
        $photo2->setPath('press.jpg');
        $photo2->setAlt('img2');
        $photo2->setCreationDate(new DateTime());
        $photo2->setFigure($this->getReference(FigureFixture::FIGURE_2));
        $manager->persist($photo2);

        $photo3 = new Photo();
        $photo3->setPath('5050.jpg');
        $photo3->setAlt('img3');
        $photo3->setCreationDate(new DateTime());
        $photo3->setFigure($this->getReference(FigureFixture::FIGURE_3));
        $manager->persist($photo3);

        $photo4 = new Photo();
        $photo4->setPath('tripod.jpg');
        $photo4->setAlt('img4');
        $photo4->setCreationDate(new DateTime());
        $photo4->setFigure($this->getReference(FigureFixture::FIGURE_4));
        $manager->persist($photo4);

        $photo5 = new Photo();
        $photo5->setPath('straight-air.jpg');
        $photo5->setAlt('img5');
        $photo5->setCreationDate(new DateTime());
        $photo5->setFigure($this->getReference(FigureFixture::FIGURE_5));
        $manager->persist($photo5);

        $photo6 = new Photo();
        $photo6->setPath('cork.jpg');
        $photo6->setAlt('img6');
        $photo6->setCreationDate(new DateTime());
        $photo6->setFigure($this->getReference(FigureFixture::FIGURE_6));
        $manager->persist($photo6);

        $photo7 = new Photo();
        $photo7->setPath('stalefish.jpg');
        $photo7->setAlt('img7');
        $photo7->setCreationDate(new DateTime());
        $photo7->setFigure($this->getReference(FigureFixture::FIGURE_7));
        $manager->persist($photo7);

        $photo8 = new Photo();
        $photo8->setPath('ollie2.jpg');
        $photo8->setAlt('img8');
        $photo8->setCreationDate(new DateTime());
        $photo8->setFigure($this->getReference(FigureFixture::FIGURE_1));
        $manager->persist($photo8);

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            FigureFixture::class,
        ];
    }
}

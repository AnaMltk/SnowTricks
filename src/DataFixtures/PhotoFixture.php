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
        $photo1->setPath('public/img/img1.jpeg');
        $photo1->setAlt('img1');
        $photo1->setCreationDate(new DateTime());
        $photo1->setFigure($this->getReference(FigureFixture::FIGURE_1));
        $manager->persist($photo1);

        $photo2 = new Photo();
        $photo2->setPath('public/img/img2.jpeg');
        $photo2->setAlt('img2');
        $photo2->setCreationDate(new DateTime());
        $photo2->setFigure($this->getReference(FigureFixture::FIGURE_2));
        $manager->persist($photo2);

        $photo3 = new Photo();
        $photo3->setPath('public/img/img3.jpeg');
        $photo3->setAlt('img3');
        $photo3->setCreationDate(new DateTime());
        $photo3->setFigure($this->getReference(FigureFixture::FIGURE_3));
        $manager->persist($photo3);

        $photo4 = new Photo();
        $photo4->setPath('public/img/img4.jpeg');
        $photo4->setAlt('img4');
        $photo4->setCreationDate(new DateTime());
        $photo4->setFigure($this->getReference(FigureFixture::FIGURE_4));
        $manager->persist($photo4);

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            FigureFixture::class,
        ];
    }
}

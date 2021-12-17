<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Video;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class VideoFixture extends Fixture implements DependentFixtureInterface
{
    
    public function load(ObjectManager $manager)
    {
        $video1 = new Video();
        $video1->setLink('https://www.youtube.com/embed/t705_V-RDcQ');
        $video1->setAlt('video1');
        $video1->setCreationDate(new DateTime());
        $video1->setFigure($this->getReference(FigureFixture::FIGURE_1));
        $manager->persist($video1);

        $video2 = new Video();
        $video2->setLink('https://www.dailymotion.com/embed/video/xo2qmf');
        $video2->setAlt('video2');
        $video2->setCreationDate(new DateTime());
        $video2->setFigure($this->getReference(FigureFixture::FIGURE_1));
        $manager->persist($video2);

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            FigureFixture::class,
        ];
    }
}

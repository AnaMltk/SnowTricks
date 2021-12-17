<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Comment;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixture extends Fixture implements DependentFixtureInterface
{
    
    public function load(ObjectManager $manager)
    {
        $comment1 = new Comment();
        $comment1->setContent('Super site');
        $comment1->setUser($this->getReference(UserFixtures::USER_ADMIN));
        $comment1->setCreationDate(new DateTime());
        $comment1->setFigure($this->getReference(FigureFixture::FIGURE_1));
        $manager->persist($comment1);

        $comment2 = new Comment();
        $comment2->setContent('Contenu très interessant');
        $comment2->setUser($this->getReference(UserFixtures::USER_ADMIN));
        $comment2->setCreationDate(new DateTime());
        $comment2->setFigure($this->getReference(FigureFixture::FIGURE_1));
        $manager->persist($comment2);

        $comment3 = new Comment();
        $comment3->setContent('Super!');
        $comment3->setUser($this->getReference(UserFixtures::USER_ADMIN));
        $comment3->setCreationDate(new DateTime());
        $comment3->setFigure($this->getReference(FigureFixture::FIGURE_1));
        $manager->persist($comment3);

        $comment4 = new Comment();
        $comment4->setContent('Merci beaucoup');
        $comment4->setUser($this->getReference(UserFixtures::USER_ADMIN));
        $comment4->setCreationDate(new DateTime());
        $comment4->setFigure($this->getReference(FigureFixture::FIGURE_1));
        $manager->persist($comment4);

        $comment5 = new Comment();
        $comment5->setContent('J\'appris mon premier trick grâce à vous');
        $comment5->setUser($this->getReference(UserFixtures::USER_ADMIN));
        $comment5->setCreationDate(new DateTime());
        $comment5->setFigure($this->getReference(FigureFixture::FIGURE_1));
        $manager->persist($comment5);

        $comment6 = new Comment();
        $comment6->setContent('Interresant');
        $comment6->setUser($this->getReference(UserFixtures::USER_ADMIN));
        $comment6->setCreationDate(new DateTime());
        $comment6->setFigure($this->getReference(FigureFixture::FIGURE_1));
        $manager->persist($comment6);

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            FigureFixture::class, UserFixtures::class,
        ];
    }
}

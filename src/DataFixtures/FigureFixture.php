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
    public const FIGURE_5 = 'figure 5';
    public const FIGURE_6 = 'figure 6';
    public const FIGURE_7 = 'figure 7';
    public const FIGURE_8 = 'figure 8';
    public const FIGURE_9 = 'figure 9';
    public const FIGURE_10 = 'figure 10';
    public function load(ObjectManager $manager)
    {
        $figure1 = new Figure();
        $figure1->setName('Ollie');
        $figure1->setDescription('Le Ollie est une impulsion  avec déformation de la planche qui permet de faire un saut, comme un ollie de skate, mais en beaucoup plus facile car les deux pieds sont attachés sur la board.');
        $figure1->setUser($this->getReference(UserFixtures::USER_ADMIN));
        $this->addReference(self::FIGURE_1, $figure1);
        $figure1->setCreationDate(new \DateTime());
        $figure1->setModificationDate(new \DateTime());
        $figure1->setGroup($this->getReference(GroupFixture::GROUP_1));
        $manager->persist($figure1);

        $figure2 = new Figure();
        $figure2->setName('Press');
        $figure2->setDescription('Un press est l’action d’incliner votre poids sur la spatule (nosepress) ou sur le talon (tailpress) de la planche, de manière à faire décoller l’autre extrémité de la planche. Cette figure est vraiment fun et peut être réalisée n’importe où en montagne, des tremplins et rails jusqu’en plein milieu d’une descente.');
        $figure2->setUser($this->getReference(UserFixtures::USER_ADMIN));
        $this->addReference(self::FIGURE_2, $figure2);
        $figure2->setCreationDate(new \DateTime());
        $figure2->setModificationDate(new \DateTime());
        $figure2->setGroup($this->getReference(GroupFixture::GROUP_1));
        $manager->persist($figure2);

        $figure3 = new Figure();
        $figure3->setName('50-50');
        $figure3->setDescription('Un 50-50 est lorsque vous glissez sur une box ou un rail (parfois appelé « jib ») tout en maintenant votre snowboard parallèle au support. La figure de snowboard 50-50 est le moyen parfait de s’habituer à la glisse en snowpark, de tester de nouvelles installations et de s’échauffer. Nous allons décrire les différentes étapes à suivre pour rider sur une box, mais ces conseils s’appliquent également aux rails, aux tubes, aux mailboxes et à la plupart des jibs.');
        $figure3->setUser($this->getReference(UserFixtures::USER_ADMIN));
        $this->addReference(self::FIGURE_3, $figure3);
        $figure3->setCreationDate(new \DateTime());
        $figure3->setModificationDate(new \DateTime());
        $figure3->setGroup($this->getReference(GroupFixture::GROUP_2));
        $manager->persist($figure3);

        $figure4 = new Figure();
        $figure4->setName('Tripod');
        $figure4->setDescription('Un tripod est une figure de snowboard très fun qui se réalise sur terrain plat. Il peut sembler compliqué, mais s’apprend en réalité plutôt rapidement. La réalisation du tripod consiste à distribuer une partie de votre poids dans la partie supérieure de votre corps et dans vos bras, tout en l’équilibrant sur la spatule ou le talon de votre planche, selon votre préférence. Nous choisirons ici l’exemple de la spatule.');
        $figure4->setUser($this->getReference(UserFixtures::USER_ADMIN));
        $this->addReference(self::FIGURE_4, $figure4);
        $figure4->setCreationDate(new \DateTime());
        $figure4->setModificationDate(new \DateTime());
        $figure4->setGroup($this->getReference(GroupFixture::GROUP_2));
        $manager->persist($figure4);

        $figure5 = new Figure();
        $figure5->setName('Straight Air');
        $figure5->setDescription('Tout comme le 50-50 sur une box ou un rail, la réussite d’un saut dépend du respect de certains principes : bien vous positionner dans l’axe pour le décollage, maintenir votre base bien plate à l’approche du tremplin, et réaliser un ollie au moment où votre planche quitte le bord. Maintenir votre base à plat, vos genoux fléchis et votre torse bien droit constituent des éléments clés pour conserver son équilibre lors d’un saut.');
        $figure5->setUser($this->getReference(UserFixtures::USER_ADMIN));
        $this->addReference(self::FIGURE_5, $figure5);
        $figure5->setCreationDate(new \DateTime());
        $figure5->setModificationDate(new \DateTime());
        $figure5->setGroup($this->getReference(GroupFixture::GROUP_2));
        $manager->persist($figure5);

        $figure6 = new Figure();
        $figure6->setName('Cork');
        $figure6->setDescription('Le diminutif de corkscrew qui signifie littéralement tire-bouchon et désignait les premières simples rotations têtes en bas en frontside. Désormais, on utilise le mot cork à toute les sauces pour qualifier les figures où le rider passe la tête en bas, peu importe le sens de rotation. Et dorénavant en compétition, on parle souvent de double cork, triple cork et certains riders vont jusqu\'au quadruple cork !');
        $figure6->setUser($this->getReference(UserFixtures::USER_ADMIN));
        $this->addReference(self::FIGURE_6, $figure6);
        $figure6->setCreationDate(new \DateTime());
        $figure6->setModificationDate(new \DateTime());
        $figure6->setGroup($this->getReference(GroupFixture::GROUP_2));
        $manager->persist($figure6);

        $figure7 = new Figure();
        $figure7->setName('Stalefish');
        $figure7->setDescription('Saisie de la carre backside de la planche entre les deux pieds avec la main arrière');
        $figure7->setUser($this->getReference(UserFixtures::USER_ADMIN));
        $this->addReference(self::FIGURE_7, $figure7);
        $figure7->setCreationDate(new \DateTime());
        $figure7->setModificationDate(new \DateTime());
        $figure7->setGroup($this->getReference(GroupFixture::GROUP_2));
        $manager->persist($figure7);

        $figure8 = new Figure();
        $figure8->setName('270');
        $figure8->setDescription('Désigne le degré de rotation, soit 3/4 de tour, fait en entrée ou en sortie sur un jib. Certains riders font également des rotations en 450 degrés avant ou après les jibs.');
        $figure8->setUser($this->getReference(UserFixtures::USER_ADMIN));
        $this->addReference(self::FIGURE_8, $figure8);
        $figure8->setCreationDate(new \DateTime());
        $figure8->setModificationDate(new \DateTime());
        $figure8->setGroup($this->getReference(GroupFixture::GROUP_2));
        $manager->persist($figure8);

        $figure9 = new Figure();
        $figure9->setName('Handplant');
        $figure9->setDescription('Un trick inspiré du skate qui consiste à tenir en équilibre sur une ou deux mains au sommet d\'une courbe. Existe avec de nombreuses variantes dans les grabs et les rotations.');
        $figure9->setUser($this->getReference(UserFixtures::USER_ADMIN));
        $this->addReference(self::FIGURE_9, $figure9);
        $figure9->setCreationDate(new \DateTime());
        $figure9->setModificationDate(new \DateTime());
        $figure9->setGroup($this->getReference(GroupFixture::GROUP_2));
        $manager->persist($figure9);

        $figure10 = new Figure();
        $figure10->setName('Backside rodeo');
        $figure10->setDescription('Une rotation tête en bas backside tournant dans le sens d\'un backflip qui peut se faire aussi bien sur un kicker, un pipe ou un hip.');
        $figure10->setUser($this->getReference(UserFixtures::USER_ADMIN));
        $this->addReference(self::FIGURE_10, $figure10);
        $figure10->setCreationDate(new \DateTime());
        $figure10->setModificationDate(new \DateTime());
        $figure10->setGroup($this->getReference(GroupFixture::GROUP_2));
        $manager->persist($figure10);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class, GroupFixture::class
        ];
    }
}

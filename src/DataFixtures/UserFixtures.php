<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    public const USER_ADMIN = 'admin';
    public $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $name = 'admin';
        $email = 'admin@gmail.com';
        $password = 'admin';

        $user = new User();

        $user->setEmail($email);
        $password = $this->encoder->encodePassword($user, 'admin');
        $user->setPassword($password);
        $user->setRoles(['ROLE_USER']);


        $manager->persist($user);
        $this->addReference(self::USER_ADMIN, $user);
        $manager->flush();
    }
}

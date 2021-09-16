<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture 
{
    public const USER_ADMIN = 'admin';
    public function load(ObjectManager $manager)
    {
        $name = 'admin';
        $email = 'admin@gmail.com';
        $password = 'admin';
        
         $user = new User();
         $user->setName($name);
         $user->setEmail($email);
         $user->setPassword($password);
         $user->setRole(['ROLE_USER']);
         $this->addReference(self::USER_ADMIN, $user);
         $manager->persist($user);

        $manager->flush();
    }
}

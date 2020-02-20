<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setName('Admin');
        $user->setEmail('admin@mail.com');
        $user->setRoles(array('Administrator'));
        $password = $this->encoder->encodePassword($user, 'password');
        $user->setPassword($password);
        $manager->persist($user);

        for ($i = 2; $i < 6; $i++) {
        $user = new User();
        $user->setName('Store'.$i);
        $user->setEmail($i.'store@mail.com');
        $user->setRoles(array('User'));
        $password = $this->encoder->encodePassword($user, 'password');
        $user->setPassword($password);
        $manager->persist($user);
    }

        $manager->flush();
    }
}

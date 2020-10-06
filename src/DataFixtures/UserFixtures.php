<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        $user = new User();
        $user->setUsername('zimzim');
        $user->setRoles(['ROLE_USER']);
        $plainPassword = 'zimzim';
        $encoded = $this->encoder->encodePassword($user, $plainPassword);

        $user->setPassword($encoded);
        $manager->persist($user);
        $manager->flush();
    }
}

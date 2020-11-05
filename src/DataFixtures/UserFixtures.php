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
        $plainPassword = $user->getUsername();
        $encoded = $this->encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);
        $user->setCreatedAt(new \DateTime());
        $user->setHealth(user::MAX_HEALTH * 2);
        $manager->persist($user);


        $user = new User();
        $user->setUsername('admin');
        $user->setRoles(['ROLE_ADMIN']);
        $plainPassword = $user->getUsername();
        $encoded = $this->encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);
        $user->setCreatedAt(new \DateTime());
        $user->setHealth(user::MAX_HEALTH * 2);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('superadmin');
        $user->setRoles(['ROLE_SUPER_ADMIN']);
        $plainPassword = $user->getUsername();
        $encoded = $this->encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);
        $user->setCreatedAt(new \DateTime());
        $user->setHealth(user::MAX_HEALTH * 2);
        $manager->persist($user);

        $manager->flush();
    }
}

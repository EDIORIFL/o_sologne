<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User;
        $user
            ->setLogin('admin')
            ->setName('Admin')
            ->setRoles([User::ROLE_SUPERADMIN])
            ->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'admin45470'
            ))
            ->setCreatedat( new DateTime('now'))
            ->setUpdatedat( new DateTime('now'))
        ;
        $manager->persist($user);

        $manager->flush();
    }
}

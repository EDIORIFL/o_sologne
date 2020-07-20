<?php

namespace App\DataFixtures;

use App\Entity\User;
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
            ->setRoles(['ROLE_SUPERADMIN'])
            ->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'admin45470'
            ))
            ->setProfil('profil_commercial')
        ;
        $manager->persist($user);

        $manager->flush();
    }
}

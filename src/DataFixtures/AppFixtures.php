<?php

namespace App\DataFixtures;

use App\Entity\ActivityArea;
use App\Entity\Prospect;
use App\Entity\ProspectStatus;
use App\Entity\Support;
use App\Entity\SupportType;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\Date;

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
            ->setRoles([User::ROLE_SUPERADMIN, User::ROLE_ADMIN, User::ROLE_USER])
            ->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'admin45470'
            ))
            ->setCreatedat( new DateTime('now'))
            ->setUpdatedat( new DateTime('now'))
        ;
        $manager->persist($user);

        $activityArea = new ActivityArea;
        $activityArea
            ->setLabel('Restaurant')
            ->setCreatedat(new DateTime('now'))
            ->setUpdatedat(new DateTime('now'));
        $manager->persist($activityArea);

        $prospectStatus = new ProspectStatus;
        $prospectStatus
            ->setLabel('A CONTACTER')
            ->setUpdatedat(new DateTime())
            ->setCreatedat(new DateTime());
        $manager->persist($prospectStatus);

        $manager->flush();

        $prospect = new Prospect;
        $prospect
            ->setIdaccount($user->getId())
            ->setIdactivityarea($activityArea->getId())
            ->setIdprospectstatus($prospectStatus->getId())
            ->setName('Don Camillo')
            ->setManager('Gilles')
            ->setAddress('54 rue Ste Catherine 45000 Orléans')
            ->setSiret('44191833100014')
            ->setTelephone('0238533897')
            ->setCreatedat(new DateTime())
            ->setUpdatedat(new DateTime());
        $manager->persist($prospect);

        $supportType = new SupportType;
        $supportType
            ->setLabel('GUIDE PRATIQUE')
            ->setCreatedat(new DateTime())
            ->setUpdatedat(new DateTime());
        $manager->persist($supportType);

        $manager->flush();

        $support = new Support;
        $support
            ->setIdsupporttype($supportType->getId())
            ->setLabel('Guide')
            ->setCreatedat(new DateTime())
            ->setUpdatedat(new DateTime());
        $manager->persist($support);

        $manager->flush();
    }
}

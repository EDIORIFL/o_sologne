<?php

namespace App\Command;

use App\Entity\User;
use DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateFirstUserCommand extends Command
{
    protected static $defaultName = 'app:create-first-user';
    private $container;
    private $encoder;

    public function __construct(ContainerInterface $container, UserPasswordEncoderInterface $encoder)
    {
        parent::__construct();
        $this->container = $container;
        $this->encoder = $encoder;
    }

    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Create the first User of the database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->container->get('doctrine')->getManager();
        $userRepository = $this->container->get('doctrine')->getRepository(User::class);
        $users = $userRepository->findAll();
        $user = new User;
        $processComplete = false;
        if (count($users) < 0) {
            $helper = $this->getHelper('question');
            $continueQuestion = new ChoiceQuestion(
                '<info>Salut Pedro, prêt à créer le premier utilisateur de cette appli ?</info>',
                ['Oui', 'Non'],
                1
            );
            $continue = $helper->ask($input, $output, $continueQuestion);
            if ($continue === 'Oui') {
                $output->writeln('<info>Okay ! Alors c\'est ti-par mon canard. Quel sera le login ?</info>');
                $loginQuestion = new Question('> ');
                $login = $helper->ask($input, $output, $loginQuestion);
                if ($login !== null) {
                    $output->writeln('Bien, va pour ' . $login . ', c\'est comme tu le sens, j\'aurais pas mis ça mais c\'est toi le chef.');
                    $output->writeln('<info>Maintenant, le mot de passe, si tu veux bien</info>');
                    $passwordQuestion = new Question('> ');
                    $passwordQuestion->setHidden(true);
                    $plainPassword = $helper->ask($input, $output, $passwordQuestion);
                    if ($plainPassword !== null) {
                        $output->writeln('Oh je vois, pas mal en effet, bien secure et tout, GGWP !');
                        $output->writeln('<info>Bon, passons à la suite, un profil particulier ?</info>');
                        $profileQuestion = new Question('> ');
                        $profile = $helper->ask($input, $output, $profileQuestion);
                        if ($profile !== null) {
                            $output->writeln('Okay, maintenant on passe aux choses sérieuses !');
                            $rolesQuestion = new ChoiceQuestion(
                                '<info>Quel rôle pour cet utilisateur ?</info>',
                                [User::ROLE_USER, User::ROLE_ADMIN, User::ROLE_SUPERADMIN],
                                0
                            );
                            $preProcessRoles = $helper->ask($input, $output, $rolesQuestion);

                            if ($preProcessRoles === User::ROLE_SUPERADMIN) {
                                $roles = [User::ROLE_SUPERADMIN, User::ROLE_ADMIN, User::ROLE_USER];
                            } elseif ($preProcessRoles === User::ROLE_ADMIN) {
                                $roles = [User::ROLE_ADMIN, User::ROLE_USER];
                            }
                            $processComplete = true;
                            $output->writeln('<info>Eh bien écoute, c\'était une discussion sympa, mais je crois qu\'il est temps pour moi d\'aller me faire un café, j\'enregistre tout ça et j\'y vais. A plus !');
                        }
                    }
                }
            } else {
                $output->writeln('Oh...');
            }
            if ($processComplete) {
                $user
                    ->setLogin($login)
                    ->setName($login)
                    ->setPassword($this->encoder->encodePassword($user, $plainPassword))
                    ->setRoles($roles)
                    ->setCreatedat(new DateTime('now'))
                    ->setUpdatedat(new DateTime('now'));
                $em->persist($user);
                $em->flush();
            }
        }
        else {
            $output->writeln('Oh oh... T\'es pas le premier mon pote, malheureusement...');
        }
        return Command::SUCCESS;
    }
}

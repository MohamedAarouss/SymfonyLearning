<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserAddInteractiveCommand extends Command
{
    protected static $defaultName = 'app:createuser:interactive';

    private $em;
    private $encoder;
    private $clientRepository;
    private $validator;

    public function __construct(
        UserPasswordEncoderInterface $encoder,
        EntityManagerInterface $em,
        ValidatorInterface $validator
    ){
        parent::__construct();

        $this->encoder = $encoder;
        $this->em = $em;
        $this->validator = $validator;
    }

    protected function configure()
    {
        $this
            ->setDescription('Create new user with questions !');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $user = new User();
        $valid = $this->validator;
        $encoder = $this->encoder;

        $helper = $this->getHelper('question');
        $questionUsername = new Question('Hello, what\'s your name ? ');
        $questionUsername->setValidator(
            function ($answer) use ($valid, $user){
                $user->setUsername($answer);
                $errors = $valid->validate($user, null, 'username');
                if(count($errors) !== 0){
                    throw new \RuntimeException(
                        $answer.' already exist'
                    );
                }

                return $answer;
            }
        );
        $questionUsername->setMaxAttempts(5);
        $helper->ask($input, $output, $questionUsername);

        $output->writeln('====================');

        $questionPassword = new Question('Choice a password for '. $user->getUsername() .' ? ');
        $questionPassword->setValidator(
            function ($answer) use ($valid, $user, $encoder){

                $user->setPassword($answer);
                $errors = $valid->validate($user, null, 'password');
                if(count($errors) !== 0){
                    throw new \RuntimeException(
                        $answer.' bad'
                    );
                }
                $encoded = $encoder->encodePassword($user, $answer);
                $user->setPassword($encoded);

                return $answer;
            }
        );
        $questionPassword->setMaxAttempts(5);
        $helper->ask($input, $output, $questionPassword);

        $output->writeln('====================');

        $errors = $this->validator->validate($user);
        if(count($errors)> 0){

            $output->writeln('<fg=red;options=bold>Erreur l\'utilisateur n\'a pas pus être créé !</>');
            foreach($errors as $error){
                $output->writeln($error->getPropertyPath().' => '.$error->getMessage());
            }
        }else {
            $this->em->persist($user);
            $this->em->flush();
            $output->writeln('<fg=green;options=bold>L\'utilisateur '.$user->getUsername().' a bien été créé</>');
        }

        return 0;
    }
}


<?php

namespace App\Command;

use App\Entity\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Input\InputArgument;

use Doctrine\Common\Persistence\ObjectManager;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserAddCommand extends Command{

    protected static $defaultName = 'app:createuser:auto';

    private $em;
    private $encoder;
    private $clientRepository;
    private $validator;

    public function __construct(EntityManagerInterface $em,UserPasswordEncoderInterface $encoder,ValidatorInterface $validator)
    {
        parent::__construct();

        $this->em = $em;
        $this->encoder = $encoder;
        $this->validator =$validator;
    }

    protected function configure()
    {
        $this
            ->setDescription('Creation d\'un utilisateur')
            ->setHelp('app:create:userauto + login + password + client')
            ->addArgument('login', InputArgument::REQUIRED, 'User Name')
            ->addArgument('password', InputArgument::REQUIRED, 'User Password')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $user = new User();
        $user->setUsername($input->getArgument('login'));
        $encoded = $this->encoder->encodePassword($user, $input->getArgument('password'));
        $user->setPassword($encoded);

        $errors = $this->validator->validate($user, null, 'username');
        if(count($errors)> 0){

            $output->writeln('<fg=red;options=bold>Erreur l\'utilisateur n\'a pas pus être créé !</>');
            foreach($errors as $error){
                $output->writeln($error->getPropertyPath().' => '.$error->getMessage());
            }
        }else {
            $this->em->persist($user);
            $this->em->flush();
            $output->writeln('L\'utilisateur '.$user->getUsername().' a bien été créé');
        }

        return 1;
    }
}

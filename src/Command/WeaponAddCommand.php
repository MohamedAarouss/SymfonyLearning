<?php

namespace App\Command;

use App\Entity\User;
use App\Event\WeaponEvent;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Input\InputArgument;

use Doctrine\Common\Persistence\ObjectManager;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class WeaponAddCommand extends Command{

    protected static $defaultName = 'app:weapon:auto';

    private $weaponEvent;

    private $dispatcher;

    public function __construct(WeaponEvent $weaponEvent, EventDispatcherInterface $dispatcher)
    {

        parent::__construct();

        $this->weaponEvent = $weaponEvent;
        $this->dispatcher = $dispatcher;
    }

    protected function configure()
    {
        $this
            ->setDescription('Creation d\'une arme')
            ->setHelp('app:weapon:auto + name + id_weapon_type + id_game')
            ->addArgument('name', InputArgument::REQUIRED, 'Name')
            ->addArgument('weaponType', InputArgument::REQUIRED, 'WeaponType')
            ->addArgument('game', InputArgument::REQUIRED, 'Game')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $this->weaponEvent->setName($input->getArgument('name'));
        $this->weaponEvent->setIdGame($input->getArgument('game'));
        $this->weaponEvent->setIdWeaponType($input->getArgument('weaponType'));
        $this->weaponEvent->setScarcity(true);

        $this->dispatcher->dispatch($this->weaponEvent, 'weapon.create');

        return 1;
    }
}

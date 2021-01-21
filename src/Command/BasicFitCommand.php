<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Input\InputArgument;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Question\Question;

class BasicFitCommand extends Command{

    protected static $defaultName = 'app:basic';

    protected function configure()
    {
        $this
            ->setDescription('Say wouuusaaa when you run')
            ->setHelp('Say a nice word')
            ->addArgument('word', InputArgument::REQUIRED, 'What is the key word ?')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $output->write('Hello My name is basic');
        $output->writeln(' Command say : ');
        $output->writeln('Wouuusaaa');

        return 1;
    }
}

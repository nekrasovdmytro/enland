<?php

namespace WordBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use WordBundle\BookReader\BookReader;

class WordExportTextToMysqlCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('word:export-text-to-mysql')
            ->setDescription('Export book to mysql for sphinx search')
            ->addArgument('count', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($count = $input->getArgument('count')) {

            $output->writeln('Adding ' . $count . ' records: processing');

            $container = $this->getContainer();

            $bookReader = new BookReader('data.txt', $container);
            $output->writeln($bookReader->saveToDb($count));

            $output->writeln('Done.');
        }else {
            $output->writeln('Please input count of records!');
        }


    }

}

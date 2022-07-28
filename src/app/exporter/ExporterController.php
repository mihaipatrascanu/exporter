<?php
namespace app\exporter;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class ExporterController extends Command
{
    protected function configure()
    {
        $this->setName('createCSV')
            ->setDescription('Creates a new CSV file.')
            ->addArgument('fileName', InputArgument::REQUIRED, 'The name of the file.')
            ->setHelp('This command allows you to create a csv file...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
        //creating the days array
        $today = date("Y-m-d");
        $data = ExporterFactory::getMoneyDay($today, $nextMonths = 11, $bonusDay = 10);
        
        print_r($data);
        
     
    
        // retrieve the argument value using getArgument()
        $output->writeln('FileName: '.$input->getArgument('fileName'));

        return 1;
    }
}
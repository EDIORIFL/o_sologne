<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\Tools\Export\ClassMetadataExporter;

class GenerateEntityMappingCommand extends Command
{
    protected static $defaultName = 'app:generate-mapping';

    protected function configure()
    {
        $this
        // the short description shown while running "php bin/console list"
        ->setDescription('Generate the mapping file to create entities')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allows you to generate a YAML file containing the mapping from an existing database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $cme = new ClassMetadataExporter();

        return Command::SUCCESS;
    }
}
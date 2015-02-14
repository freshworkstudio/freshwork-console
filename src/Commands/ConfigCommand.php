<?php  namespace Freshwork\ConsoleUtility\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class ConfigCommand extends BaseCommand
{
    protected function configure()
    {
        $this
            ->setName('edit')
            ->setDescription('Create new development project')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $command = executable(). ' '.config_path();

        $process = new Process($command);

        $process->run(function($type, $line) use ($output)
        {
            $output->write($line);
        });

    }
}
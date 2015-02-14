<?php  namespace Freshwork\ConsoleUtility\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class InitCommand extends BaseCommand
{
    protected function configure()
    {
        $this
            ->setName('init')
            ->setDescription('Create configuration file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if(is_dir(base_path())){
            $output->writeln('It\'s already initialized');
            return;
        }

        mkdir(base_path());
        copy(__DIR__.'/../config.json',base_path().'/config.json');

        $output->writeln('<comment></comment>');

    }
}
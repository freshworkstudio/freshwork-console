<?php  namespace Freshwork\ConsoleUtility\Commands;

use Freshwork\ConsoleUtility\HomesteadProcess;
use Freshwork\ConsoleUtility\Traits\ProjectConfigurationTrait;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class NewCommand extends BaseCommand
{
    use ProjectConfigurationTrait;

    protected function configure()
    {
        $this
            ->setName('project:new')
            ->setDescription('Edit your configuration')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'The name of the project'
            )
            ->addOption(
                'domain',
                'd',
                InputOption::VALUE_REQUIRED,
                'The local domain name to be added to your hosts file'
            )
            ->addOption(
                'public_dir',
                'pd',
                InputOption::VALUE_REQUIRED,
                'The public html directory'
            )
            ->addOption(
                'project_dir',
                'prd',
                InputOption::VALUE_REQUIRED,
                'The project directory relative to code directory folder'
            )
            ->addOption(
                'no-laravel',
                'nl',
                InputOption::VALUE_NONE,
                'Indicates if the projects is a Laravel one. '
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        list($homestead_code_directory, $public_directory,$project_directory, $project_domain,$simple_name) = $this->configureProjectVariables($input);




        $this->runServeCommand($input, $output);

        $output->writeln("<comment>Creating project directory at $homestead_code_directory/$project_directory </comment>");

        $this->createProjectDirectory($homestead_code_directory, $project_directory);

        $output->writeln("<comment>Installing Laravel...</comment>");

        (new HomesteadProcess([
            "cd $homestead_code_directory/$project_directory",
            "composer create-project laravel/laravel . --prefer-dist"
        ]))->setTimeout(600)->run();

        $output->writeln("<comment>Installation complete</comment>");
        $output->writeln("<comment>Now you can access your new site at http://$project_domain/</comment>");

    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws \Exception
     */
    protected function runServeCommand(InputInterface $input, OutputInterface $output)
    {
        $serve = $this->getApplication()->find('project:serve');

        $serve->run($input, $output);
    }

    /**
     * @param $homestead_code_directory
     * @param $project_directory
     */
    protected function createProjectDirectory($homestead_code_directory, $project_directory)
    {
        (new HomesteadProcess("mkdir -p $homestead_code_directory/$project_directory"))->run();
    }
}
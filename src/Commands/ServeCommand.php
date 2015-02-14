<?php  namespace Freshwork\ConsoleUtility\Commands;

use Freshwork\ConsoleUtility\HomesteadProcess;
use Freshwork\ConsoleUtility\Traits\ProjectConfigurationTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class ServeCommand extends BaseCommand
{
    use ProjectConfigurationTrait;

    protected function configure()
    {
        $this
            ->setName('project:serve')
            ->setDescription('Add project domain to hosts file and add it to homestead nginx sites.')
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
                'The public html directory relative to code directory folder'
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
        list($homestead_code_directory, $public_directory,$project_directory, $project_domain,$simple_name) = $this->configureProjectVariables($input);

        $output->writeln('<comment>Serving domain...</comment>');

        $this->run_serve_cmd($project_domain, $homestead_code_directory, $public_directory);

        $homestead_ip = config('homestead_ip');
        $hosts_file = config('hosts_file');

        if(!is_file($hosts_file))
        {
            throw new \Exception('Hosts file can\'t be reached. Verify your \'hosts_file\' configuration - '.$hosts_file);
        }
        else
        {
            $p = new Process("sudo sed -i '' '/$homestead_ip '$project_domain'/ d' $hosts_file");
            $p->run(function ($type, $line) use ($output) {
               //$output->write($line);
            });

            $p = new Process("sudo sh -c \"echo $homestead_ip $project_domain >>  $hosts_file\"");
            $p->run(function ($type, $line) use ($output) {
                //$output->write($line);
            });
        }

        $output->writeln('<comment>Site added to nginx and local hosts file</comment>');

    }


    /**
     * @param $project_domain
     * @param $homestead_code_directory
     * @param $public_directory
     * @return Process
     */
    protected function run_serve_cmd($project_domain, $homestead_code_directory, $public_directory)
    {
        $process = new HomesteadProcess([
            'sudo dos2unix /vagrant/scripts/serve.sh',
            "sudo bash /vagrant/scripts/serve.sh $project_domain {$homestead_code_directory}/{$public_directory}"
        ]);

        $process->run();

        return $process;
    }


}
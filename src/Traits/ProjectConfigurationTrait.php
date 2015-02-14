<?php
/**
 * Created by PhpStorm.
 * User: gonzunigad
 * Date: 14-02-15
 * Time: 12:48
 */

namespace Freshwork\ConsoleUtility\Traits;


use Symfony\Component\Console\Input\InputInterface;

trait ProjectConfigurationTrait {

    /**
     * @param InputInterface $input
     * @return array
     */
    protected function configureProjectVariables(InputInterface $input)
    {
        $name = $input->getArgument('name');
        $homestead_code_directory = config('homestead_code_directory');

        $name_as_directory = str_replace(['.', '\\'], '/', $name);

        $name_as_directory_parts = explode('/', $name_as_directory);

        $project_directory = $input->getOption('project_dir')?:$name_as_directory;

        $possible_public_dir = $input->getOption('no-laravel') ?: $name_as_directory . '/public';

        $public_dir = $input->getOption('public_dir') ?: $possible_public_dir;

        $simple_name = end($name_as_directory_parts);
        $project_domain = $input->getOption('domain') ?:  $simple_name. '.app';
        return array($homestead_code_directory, $public_dir,$project_directory, $project_domain,$simple_name);
    }

}
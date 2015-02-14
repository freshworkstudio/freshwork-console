<?php  namespace Freshwork\ConsoleUtility\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Process\Process;

class BaseCommand extends Command {
    protected function process($command,\Closure $cb=null,$cwd=null,$timeout=null){
        $process = new Process($command,$cwd,array_merge($_SERVER, $_ENV),null,$timeout);
        $process->run($cb);
    }
}
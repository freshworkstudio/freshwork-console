<?php namespace Freshwork\ConsoleUtility;
use Symfony\Component\Process\Process;

class HomesteadProcess extends Process {

    protected $is_homestead_up = false;


    function __construct()
    {
        $args = func_get_args();
        $this->makeSureHomesteadIsRunning();
        if(is_array($args[0])){
            $args[0] = implode("\n",$args[0]);
        }
        $args[0] = config('ssh_connection_cmd') . " '
            {$args[0]}
        '";

        return call_user_func_array([parent,'__construct'],$args);
    }

    private function makeSureHomesteadIsRunning()
    {
        if($this->is_homestead_up){
            parent::__construct('homestead up')->run();
            $this->is_homestead_up = true;
        }
    }
}
<?php

define('DS',DIRECTORY_SEPARATOR);

function base_path(){
    if (isset($_SERVER['HOME']))
    {
        return $_SERVER['HOME'].'/.freshwork';
    }
    else
    {
        return $_SERVER['HOMEDRIVE'].$_SERVER['HOMEPATH'].DS.'.freshwork';
    }
}

/**
 * Find the correct executable to run depending on the OS.
 *
 * @return string
 */
function executable()
{
    if (strpos(strtoupper(PHP_OS), 'WIN') === 0)
    {
        return 'start';
    }
    elseif (strpos(strtoupper(PHP_OS), 'DARWIN') === 0)
    {
        return 'open';
    }
    return 'xdg-open';
}

function config_path(){
    return base_path().'/config.json';
}

function parse_config(){
    $file_content = file_get_contents(config_path());
    return json_decode($file_content);
}

function config($key,$default_value = null){
    $configs = parse_config();
    return isset($configs->$key)?$configs->$key:$default_value;
}
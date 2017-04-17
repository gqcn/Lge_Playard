<?php
namespace Lge;

if(!defined('LGE')){
    exit('Include Permission Denied!');
}

class Controller_Test extends BaseController
{
    public function index()
    {
        $descriptorspec = array(
            0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
            1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
            2 => array("file", "/tmp/error-output.txt", "a") // stderr is a file to write to
        );

        $cwd = '/tmp';
        $env = array('some_option' => 'aeiou');

        $process = proc_open('/bin/bash', $descriptorspec, $pipes, $cwd, $env);
        //$process = proc_open('/usr/bin/xterm -hold', $descriptorspec, $pipes, $cwd, $env);

        if (is_resource($process)) {
            stream_set_blocking($pipes[0], 0);
            stream_set_blocking($pipes[1], 0);
            fwrite($pipes[0], "vim /home/john/Documents/temp.txt".PHP_EOL);
            while (true) {
                $result = stream_get_contents($pipes[1]);
                if (empty($result)) {
                    usleep(100000);
                    //var_dump('sleep');
                } else {
                    var_dump($result);
                }
            }
            proc_close($process);
        }
    }
}

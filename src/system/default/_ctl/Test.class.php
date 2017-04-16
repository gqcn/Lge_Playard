<?php
namespace Lge;

if(!defined('LGE')){
    exit('Include Permission Denied!');
}

class Controller_Test extends BaseController
{
    public function index()
    {
        $path = 'ssh://john@120.76.249.69:8822//home/john/www/lge';
        preg_match("/ssh:\/\/(.+?)@([^:]+):{0,1}(\d*)\/(\/.+)/", $path, $match);
        print_r($match);
        exit();
        $sshShellCmds = array(
            array("ll -a", false, 100),
            // array("top", false, 80000)
        );
        $ssh = new Lib_Network_Ssh('127.0.0.1', '8822', 'john', '8692651');
        $r = $ssh->sendFile("/home/john/Documents/temp.txt", "/home/john/temp/temp.txt", 0777);
        var_dump($r);
    }
}

<?php
namespace Lge;

if(!defined('LGE')){
	exit('Include Permission Denied!');
}

class Controller_Test extends BaseController
{
    public function index()
    {
        //$no = str_replace('.', '', microtime(true));
        $no = time();
        for ($i = 0; $i < 6; $i++) {
            $no .= rand(0, 9);
        }
        var_dump($no);
        var_dump(base_convert($no, 10, 36));
    }
}

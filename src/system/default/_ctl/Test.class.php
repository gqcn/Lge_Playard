<?php
namespace Lge;

if(!defined('LGE')){
    exit('Include Permission Denied!');
}

class Controller_Test extends BaseController
{
    public function index()
    {
        var_dump(basename('/home/john/temp/test/127.0.0.1/data/'));
        exit();
        $files = array(
            '11111',
            '11.gz',
            '11.bz',
            '11.bz2',
        );
        foreach ($files as $k => $file) {
            if (!preg_match('/.+\.bz2/', $file)) {
                unset($files[$k]);
            }
        }
        print_r($files);
        exit();

        $files = array_diff(scandir('/home/john/temp/test/127.0.0.1/data/'), array('..', '.'));
        print_r($files);


    }
}

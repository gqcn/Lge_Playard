<?php
namespace Lge;

if(!defined('LGE')){
    exit('Include Permission Denied!');
}

class Controller_Test extends BaseController
{
    public function index()
    {
        $db = Instance::database();
        $r = $db->query('select * from lge_setting');
        var_dump($r);
        sleep(4);
        $r = $db->query('select * from lge_setting');
        print_r($db);
    }
}

<?php
namespace Lge;

if(!defined('LGE')){
	exit('Include Permission Denied!');
}

class Controller_Test extends BaseController
{
    public function index()
    {
        try {
            exception('test');
        } catch(\Exception $e) {
            print_r($e);
        }
    }
}

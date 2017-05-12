<?php
namespace Lge;

if(!defined('LGE')){
    exit('Include Permission Denied!');
}

class Controller_Test extends BaseController
{
    public function index()
    {
        var_dump(!empty(@Lib_XmlParser::xml2Array(1)));
    }
}

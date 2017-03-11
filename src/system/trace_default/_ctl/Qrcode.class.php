<?php
namespace Lge;

if (!defined('LGE')) {
	exit('Include Permission Denied!');
}

class Controller_Qrcode extends Controller_Base
{
    
    /**
     * 生成二维码.
     */
    public function index()
    {
        include Core::$incDir.'library/phpqrcode/phpqrcode.php';
        $v = Lib_Request::get('v');
        \QRcode::png($v);
    }
}
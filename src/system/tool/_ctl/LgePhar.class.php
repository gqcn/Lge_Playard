<?php
namespace Lge;

if(!defined('LGE')){
	exit('Include Permission Denied!');
}

/**
 * 生成Lge框架的打包文件。
 *
 */
class Controller_LgePhar extends Controller_Base
{
    public  $startSession = false;    // 是否开启session
    public  $sessionID    = null;     // 设置session id

    public function index()
    {
        $phar = new \Phar('lge.phar');
        $phar->buildFromDirectory('/home/john/Workspace/PHP/Lge/Lge/src/_frm');
        $phar->compressFiles(\Phar::GZ);
        $phar->stopBuffering();
        $phar->setStub($phar->createDefaultStub('common.inc.php'));
        echo "Done!\n";
        exit();
    }

}

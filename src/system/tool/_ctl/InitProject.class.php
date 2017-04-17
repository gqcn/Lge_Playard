<?php
namespace Lge;

if(!defined('LGE')){
	exit('Include Permission Denied!');
}

/**
 * 使用 /doc/init 下的数据初始化项目，可反复初始化，多次执行只会影响初始化数据.
 */
class Controller_InitProject extends Controller_Base
{
    public  $startSession = false;    // 是否开启session
    public  $sessionID    = null;     // 设置session id

    public function index()
    {
        $this->_initSqlByPath(L_ROOT_PATH.'../doc/数据库初始化脚本/');
        echo "Done!".PHP_EOL;
    }

    /**
     * SQL文件执行初始化.
     *
     * @param string $path       存放SQL文件的en 文件夹路径.
     * @param string $dbItemName 数据库配置项名称.
     *
     * @return void
     */
    private function _initSqlByPath($path, $dbItemName = 'default')
    {
        $db    = Instance::database($dbItemName);
        $files = scandir($path);
        foreach ($files as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            $filePath = realpath($path.$file);
            if (is_dir($filePath)) {
                self::_initSqlByPath($filePath);
            } else {
                $fileType = Lib_FileSys::getFileType($filePath);
                if (strcasecmp($fileType, 'sql') == 0) {
                    echo "Initializing {$filePath}".PHP_EOL;
                    $content = file_get_contents($filePath);
                    $db->query($content, array(), 'master');
                }
            }
        }
    }

}

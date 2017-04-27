<?php
/**
 * PHP CodeSniffer代码检测辅助工具
 *
 * @author john
 */

namespace Lge;

if (!defined('LGE')) {
    exit('Include Permission Denied!');
}

/**
 * PHP CodeSniffer代码检测辅助工具
 */
class Controller_CodeSniffer extends Controller_Base
{

    /**
     * 检测目录中的代码规范错误，并且整理返回
     *
     * @return void
     */
    public function index()
    {
        $option  = Lib_ConsoleOption::instance();
        $dirPath = $option->getOption('dir');
        $result = shell_exec("phpcs {$dirPath}");
        $resultArray = explode("\n", $result);
        $errorList   = array();
        $errorIndex  = -1;
        foreach ($resultArray as $line) {
            if (preg_match('/(.+?)\|(.+?)\|(.+)/', $line, $match)) {
                $num   = trim($match[1]);
                $type  = trim($match[2]);
                $error = trim($match[3]);
                if (!empty($num) && !empty($type)) {
                    $errorIndex++;
                    $errorList[$errorIndex]  = $this->_parseError($error);
                } else {
                    $errorList[$errorIndex] .= ' '.$this->_parseError($error);
                }
            }
        }
        $errorList = array_unique($errorList);
        sort($errorList);
        foreach ($errorList as $v) {
            echo $v.PHP_EOL;
        }
    }

    /**
     * 解析错误信息
     *
     * @param string $error 错误信息
     *
     * @return string
     */
    private function _parseError($error)
    {
        $result = $error;
        if (preg_match('/\[[\w\s]*\]\s*(.+)/', $error, $match)) {
            $result = $match[1];
        }
        return $result;
    }

}

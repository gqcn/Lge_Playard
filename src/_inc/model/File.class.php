<?php
if(!defined('PhpMe')){
    exit('Include Permission Denied!');
}
/**
 * 文件管理模型。
 *
 */
class Model_File extends BaseModel
{
    /**
     * 上传文件
     * 
     * @param array $FILE  文件域数组.
     * @param string $type 文件类型(file|image|video|audio).
     * 
     * @return string|false
     */
    public function upload($FILE, $type = 'image')
    {
        importLib('FileSYS');
        $subPath = "userfiles/{$this->_session['user']['uid']}/{$type}/";
        $dirPath = ROOT_PATH.$subPath;
        if (!file_exists($dirPath)) {
            if (!@mkdir($dirPath, 0777, true)) {
                return false;
            }
        }
        $fileName = FileSYS::uploadfile($FILE, $dirPath);
        if ($fileName) {
            $filePath = $subPath.$fileName;
        } else {
            return false;
        }
    }
}

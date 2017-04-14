<?php
if(!defined('PhpMe')){
    exit('Include Permission Denied!');
}
/**
 * 网站管理模型。
 *
 */
class Model_Site extends BaseModelTable
{
    public function setTableAndPri()
    {
        $this->table   = 'site';
        $this->primary = 'site_id';
    }
    
    /**
     * 保存网站设置.
     * 
     * @param array $data 设置信息数组.
     * 
     * @return void
     */
    public function saveSetting($data)
    {
        $settingFilePath = ROOT_PATH.'_cfg/setting.inc.php';
        $settingContent  = "<?php\n/*该文件由系统后台自动生成，请勿修改*/\nreturn ".var_export($data, true).";";
        file_put_contents($settingFilePath, $settingContent);
    }
    
    /**
     * 读取网站设置.
     * 
     * @return array
     */
    public function getSetting()
    {
        $setting         = array();
        $settingFilePath = ROOT_PATH.'_cfg/setting.inc.php';
        if (file_exists($settingFilePath)) {
            $setting = include $settingFilePath;
        }
        return $setting;
    }
}
?>
<?php
namespace Lge;

if(!defined('LGE')){
    exit('Include Permission Denied!');
}

class Controller_Base extends BaseController
{
    public $menus          = array(); // 菜单列表
    public $startSession   = true;    // 是否开启session
    public $sessionID      = null;    // 设置session id
    public $breadCrumbs    = array(); // 面包屑列表
    public $currentMenu    = array(); // 当前菜单，可设置
    public $bindTableName  = '';      // 当前控制器绑定的数据库表名称


    /**
     * 设置面包屑.
     *
     * @param array $breadCrumbs 面包屑.
     *
     * @return void
     */
    public function setBreadCrumbs(array $breadCrumbs)
    {
        $this->breadCrumbs = $breadCrumbs;
    }

    /**
     * 设置当前菜单.
     *
     * @param string $ctl ctl.
     * @param string $act act.
     *
     * @return void
     */
    public function setCurrentMenu($ctl, $act)
    {
        $this->currentMenu = array(
            'ctl' => $ctl,
            'act' => $act,
        );
    }

    /**
     * 动态设置菜单.
     *
     * @param array $menus 后台显示的菜单数组，具体格式请参考menu.inc.php.
     */
    public function setMenus(array $menus)
    {
        $this->menus = $menus;
    }

    /**
     * (non-PHPdoc)
     * @see BaseApp::display()
     */
    public function display($tpl = 'index')
    {
        $this->assigns(array(
            'system'            => Core::$sys,
            'config'            => Config::getFile(),
            'session'           => $this->_session,
            'breadCrumbs'       => $this->breadCrumbs,
            'sysurl'            => '/system/admin/template',
            'limits'            => array(10, 30, 50, 100),
        ));
        // 是否只展示内容，不展示页面框架
        $onlyContent = Lib_Request::get('__content');
        if ($onlyContent) {
            $tpl = Instance::template()->getVar('mainTpl');
        }
        parent::display($tpl);
    }
}


<?php
namespace Lge;

if(!defined('LGE')){
	exit('Include Permission Denied!');
}
/**
 * 云服务 - 接口管理
 */
class Controller_Doc extends Controller_Base
{
    public $bindTableName = '_api_app_api';
    public $actMap        = array(
        'list' => 'apiList'
    );

    /**
     * 应用信息
     *
     * @var array
     */
    public $app = array();

    /**
     * 初始化操作
     */
    public function __init()
    {
        $appid     = Lib_Request::get('appid');
        $appid     = intval($appid);
        $this->app = Instance::table('_api_app')->getOne('*', array('id' => $appid));
        if (empty($this->app)) {
            exit('应用不存在！');
        }
        $this->assign('app', $this->app);
    }

    /**
     * 接口文档.
     */
    public function index()
    {
        $this->assigns(
            array(
                'title'   => '接口文档',
                'apiList' => Model_Api_Api::instance()->getApiTreeByAppId($this->app['id']),
                'mainTpl' => 'doc/index',
            )
        );
        $this->display();
    }
}
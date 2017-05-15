<?php
namespace Lge;

if(!defined('LGE')){
    exit('Include Permission Denied!');
}
/**
 * 云服务 - 云服务应用管理模型。
 *
 */
class Model_Api_App extends BaseModelTable
{
    public $table = '_api_app';

    /**
     * 获得实例.
     *
     * @return Model_Api_App
     */
    public static function instance()
    {
        return self::_instanceInternal(__CLASS__);
    }

    /**
     * 获取当前我可管理的应用列表.
     *
     * @return array
     */
    public function getMyApps()
    {
        return $this->getAll(
            '*',
            array('uid' => $this->_session['user']['uid']),
            null,
            '`order` asc, id asc'
        );
    }

    /**
     * 获取当前系统所有的应用列表.
     *
     * @return array
     */
    public function getAllApps()
    {
        return $this->getAll(
            '*',
            null,
            null,
            '`order` asc, id asc'
        );
    }

}
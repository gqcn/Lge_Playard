<?php
namespace Lge;

if(!defined('LGE')){
    exit('Include Permission Denied!');
}
/**
 * 云服务 - 云服务接口管理模型。
 *
 */
class Model_Api_Api extends BaseModelTable
{
    public $table = '_api_api';

    /**
     * 获得实例.
     *
     * @return Model_Api_Api
     */
    public static function instance()
    {
        return self::_instanceInternal(__CLASS__);
    }

    /**
     * 获取指定API信息.
     *
     * @param integer $id API ID
     *
     * @return array
     */
    public function getApiInfoById($id)
    {
        $tables = '_api_app_api api left join _api_app app on(app.id=api.appid)';
        $fields = 'api.*,app.address_prod,app.address_test';
        $api    = Instance::table($tables)->getOne($fields, array('api.id' => $id));
        if (!empty($api)) {
            $api['content']      = json_decode($api['content'], true);
            $api['address_prod'] = empty($api['address_prod']) ? $api['address'] : rtrim($api['address_prod'], '/').$api['address'];
            $api['address_test'] = empty($api['address_test']) ? $api['address'] : rtrim($api['address_test'], '/').$api['address'];
        }
        return $api;
    }

    /**
     * 获取指定API信息.
     *
     * @param string  $address API地址
     * @param integer $appid   应用ID
     *
     * @return array
     */
    public function getApiInfoByAddress($address, $appid)
    {
        $tables = '_api_app_api api left join _api_app app on(app.id=api.appid)';
        $fields = 'api.*,app.address_prod,app.address_test';
        $api    = Instance::table($tables)->getOne($fields, array('api.appid' => $appid, 'api.address' => $address));
        if (!empty($api)) {
            $api['content']      = json_decode($api['content'], true);
            $api['address_prod'] = empty($api['address_prod']) ? $api['address'] : rtrim($api['address_prod'], '/').$api['address'];
            $api['address_test'] = empty($api['address_test']) ? $api['address'] : rtrim($api['address_test'], '/').$api['address'];
        }
        return $api;
    }
}
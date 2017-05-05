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
            $api['address_crossdomain_test'] = Lib_Url::getCurrentUrlWithoutUri().'test/'.$api['id'];
            $api['address_crossdomain_prod'] = Lib_Url::getCurrentUrlWithoutUri().'prod-test/'.$api['id'];
        }
        return $api;
    }
}
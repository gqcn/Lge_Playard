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
    public $table = '_api_app_api';

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
     * 获取指定应用的API接口列表，通过API类别进行分类
     *
     * @param integer $appid 应用ID
     *
     * @return array
     */
    public function getApiTreeByAppId($appid)
    {
        $apiList  = array();
        $catArray = array();
        $app      = Model_Api_App::instance()->getOne('*', array('id' => $appid));
        if (empty($app)) {
            return array();
        }
        $treeList = Model_Api_Category::instance()->getCatTree($app['id']);
        foreach ($treeList as $k => $v) {
            $v['name']          = $v['old_name'];
            $catArray[$v['id']] = $v;
        }
        $list = $this->getAll('*', array('appid' => $app['id']), null, "`order` ASC,`id` ASC");
        // 分类绑定接口
        foreach ($list as $api) {
            $catid = $api['cat_id'];
            if (isset($catArray[$catid])) {
                if (!isset($catArray[$catid]['api_list'])) {
                    $catArray[$catid]['api_list'] = array();
                }
                $api['status_name'] = Module_Api::instance()->statuses[$api['status']];
                $api['content']     = json_decode($api['content'], true);
                if ($api['address'][0] == '/') {
                    $api['address_prod']             = empty($app['address_prod']) ? $api['address'] : rtrim($app['address_prod'], '/').$api['address'];
                    $api['address_test']             = empty($app['address_test']) ? $api['address'] : rtrim($app['address_test'], '/').$api['address'];
                    $api['address_crossdomain_test'] = Lib_Url::getCurrentUrlWithoutUri().'dtest/'.$app['id'].$api['address'];
                    $api['address_crossdomain_prod'] = Lib_Url::getCurrentUrlWithoutUri().'ptest/'.$app['id'].$api['address'];
                } else {
                    $api['address_prod']             = $api['address'];
                    $api['address_test']             = $api['address'];
                    $api['address_crossdomain_test'] = Lib_Url::getCurrentUrlWithoutUri().'dtest/'.$app['id'].'/'.$api['address'];
                    $api['address_crossdomain_prod'] = Lib_Url::getCurrentUrlWithoutUri().'ptest/'.$app['id'].'/'.$api['address'];
                }

                $catArray[$catid]['api_list'][] = $api;
            }
        }

        // 分类处理
        foreach ($catArray as $cat) {
            if (!empty($cat['api_list'])) {
                $pid           = $cat['pid'];
                $ancestorNames = array($cat['name']);
                while (isset($catArray[$pid])) {
                    $ancestorNames[] = $catArray[$pid]['name'];
                    $pid             = $catArray[$pid]['pid'];
                }
                $cat['ancestor_names'] = implode(' - ', array_reverse($ancestorNames));
                $apiList[] = $cat;
            }
        }
        return $apiList;
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
            $api['content'] = json_decode($api['content'], true);
            if ($api['address'][0] == '/') {
                $api['address_prod'] = empty($app['address_prod']) ? $api['address'] : rtrim($app['address_prod'], '/').$api['address'];
                $api['address_test'] = empty($app['address_test']) ? $api['address'] : rtrim($app['address_test'], '/').$api['address'];
            } else {
                $api['address_prod'] = $api['address'];
                $api['address_test'] = $api['address'];
            }
        }
        return $api;
    }
}
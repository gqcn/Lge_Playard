<?php
/**
 * 接口跨域测试控制器
 *
 * @author john
 */

namespace Lge;

if (!defined('LGE')) {
    exit('Include Permission Denied!');
}

/**
 * 云服务 - 接口测试
 */
class Controller_Test extends Controller_Base
{

    /**
     * 初始化
     *
     * @return void
     */
    public function __init()
    {
        Lib_Response::allowCrossDomainRequest();
    }

    /**
     * 测试接口入口.
     *
     * @return void
     */
    public function index()
    {
        $id  = Lib_Request::get('__id');
        $env = Lib_Request::get('__env', 'test');
        $env = empty($env) ? 'test' : $env;
        if (empty($id)) {
            exception('请输入需要测试的API接口ID！');
        }
        $api = Model_Api_Api::instance()->getApiInfoById($id);
        if (empty($api)) {
            exception('请求的API接口不存在！');
        }
        $key = "address_{$env}";
        if (empty($api[$key])) {
            exception('请求的API接口环境地址不存在！');
        }
        $remote = $api[$key];
        $method = Lib_Request::getMethod();
        $method = strtolower($method);
        $params = array();
        switch ($method) {
            case 'get':
                $params = $this->_get;
                unset($params[Core::$ctlName], $params[Core::$actName], $params['__id'], $params['__env']);
                break;

            case 'post':
                $params = $this->_post;
                break;
        }
        if (!empty($remote)) {
            $http = new Lib_Network_Http();
            $result = $http->send($remote, $params, $method, 0);
            echo $result;
        }
    }

}
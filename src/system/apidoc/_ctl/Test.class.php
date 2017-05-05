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
        $method = Lib_Request::getMethod();
        $method = strtolower($method);
        $params = array();
        $remote = $this->_get['__r'];
        switch ($method) {
            case 'get':
                $params = $this->_get;
                unset($params[Core::$ctlName], $params[Core::$actName], $params['__r']);
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
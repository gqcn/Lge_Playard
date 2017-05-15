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
        $appid = Lib_Request::get('__appid');
        if (empty($appid)) {
            exception('请输入需要测试的API接口ID！');
        }
        $address = Lib_Request::get('__address');
        if (strpos($address, 'http://') !== false) {
            $address = ltrim($address, '/');
        }
        $api = Model_Api_Api::instance()->getApiInfoByAddress($address, $appid);
        if (empty($api)) {
            exception('请求的API接口不存在！');
        }
        $env = Lib_Request::get('__env');
        $env = empty($env) ? 'test' : $env;
        $key = "address_{$env}";
        if (empty($api[$key])) {
            exception('请求的API接口环境地址不存在！');
        }
        $remote = $api[$key];
        $method = Lib_Request::getMethod();
        $method = strtolower($method);
        switch ($method) {
            case 'get':
                $params = $this->_get;
                unset($params[Core::$ctlName], $params[Core::$actName], $params['__id'], $params['__env']);
                break;

            case 'post':
                $params = $this->_post;
                break;

            default:
                $params = Lib_Request::getInput();
                break;
        }
        if (!empty($remote)) {
            $session   = array();
            $sessionid = Lib_Request::getRequest('__sessionid');
            if (!empty($sessionid)) {
                $session = $this->_getSession($sessionid);
            }
            $http = new Lib_Network_Http();
            $http->setBrowserMode(true);
            if (!empty($sessionid) && !empty($session['cookie'])) {
                $http->setCookie($session['cookie']);
            }
            $result = $http->send($remote, $params, $method, 1);
            if ($this->_isJson($result)) {
                header('Content-type: application/json');
            } elseif ($this->_isXml($result)) {
                header("Content-type: text/xml");
            }
            $cookie = $http->getCookie();
            $cookie = trim($cookie);
            if (!empty($sessionid) && !empty($cookie)) {
                $session = array(
                    'cookie' => $cookie,
                );
                $this->_saveSession($sessionid, $session);
            }
            echo $result;
        }
    }

    /**
     * 保存自定义session数据
     *
     * @param string $sessionid
     * @param mixed  $data
     *
     * @return void
     */
    private function _saveSession($sessionid, $data)
    {
        if (!file_exists('/tmp/lge-api-test')) {
            mkdir('/tmp/lge-api-test', 0777);
        }
        file_put_contents("/tmp/lge-api-test/{$sessionid}", json_encode($data));
    }

    /**
     * 获得session值.
     *
     * @param string $sessionid
     *
     * @return mixed|string
     */
    private function _getSession($sessionid)
    {
        $result = '';
        $path   = "/tmp/lge-api-test/{$sessionid}";
        if (file_exists($path)) {
            $content = file_get_contents($path);
            $result  = json_decode($content, true);
        }
        return $result;
    }

    /**
     * 判断所给内容是否为XML格式
     *
     * @param $content
     *
     * @return array
     */
    private function _isXml($content)
    {
        return Lib_XmlParser::isXml($content);
    }

    /**
     * 判断所给内容是否为JSON格式
     *
     * @param $content
     *
     * @return bool
     */
    private function _isJson($content)
    {
        return (@json_decode($content) === false) ? false : true;
    }

}
<?php
namespace Lge;

if(!defined('LGE')){
	exit('Include Permission Denied!');
}
/**
 * 云服务 - 接口测试
 */
class Controller_Api_Test extends AceAdmin_BaseControllerAuth
{
    public $bindTableName = '_api_test';

    public $actMap = array(
        'list' => 'testlist'
    );

    /**
     * 测试列表.
     */
    public function index()
    {
        $appid = Lib_Request::get('appid');
        $appid = intval($appid);
        $app   = Instance::table('_api_app')->getOne('*', array('id' => $appid, 'uid' => $this->_session['user']['uid']));
        if (empty($app)) {
            $app = Instance::table('_api_app')->getOne('*', array('uid' => $this->_session['user']['uid']), null, "`order` ASC,`id` ASC");
            if (empty($app)) {
                $this->addMessage('您当前没有任何应用信息，请先添加应用后进行操作', 'info');
                Lib_Redirecter::redirectExit('/api.app');
            } else {
                Lib_Redirecter::redirectExit('/api.test?appid='.$app['id']);
            }
        }
        $this->setBreadCrumbs(array(
            array(
                'icon' => 'fa fa-cloud',
                'name' => '服务管理',
                'url'  => '/api.app',
            ),
            array(
                'icon' => '',
                'name' => '应用管理',
                'url'  => '/api.app',
            ),
            array(
                'icon' => '',
                'name' => $app['name'],
                'url'  => '/api.test?appid='.$app['id'],
            ),
            array(
                'icon' => '',
                'name' => '接口测试',
                'url'  => '',
            ),
        ));

        $this->assigns(
            array(
                'app'      => Instance::table('_api_app')->getOne('*', array('id' => $appid)),
                'apps'     => Model_Api_App::instance()->getMyApps(),
                'catList'  => Model_Api_Category::instance()->getCatTree($appid),
                'mainTpl' => 'api/test/index',
            )
        );
        $this->display();
    }

    /**
     * 接口测试列表
     */
    public function testlist()
    {
        $key         = Lib_Request::get('key');
        $appid       = Lib_Request::get('appid');
        $condition   = array();
        $condition[] = array("uid = {$this->_session['user']['uid']}");
        if (!empty($appid)) {
            $condition[] = array("and appid={$appid}");
        }
        if (!empty($key)) {
            $condition[] = array("and name like '%{$key}%'");
        }
        $defaultTestData = array(
            'id'      => 0,
            'name'    => '(默认接口测试)',
            'address' => '-',
        );
        $list = Instance::table($this->bindTableName)->getAll('*', $condition, null, "`order` ASC,`id` ASC", null, null, 'id');
        $list = array_merge(array(0 => $defaultTestData), $list);
        $this->assigns(array(
            'list'     => $list,
            'mainTpl' => 'api/test/embed_list',
        ));
        $this->display();
    }

    /**
     * 接口测试.
     */
    public function item()
    {
        $id      = Lib_Request::get('id');
        $appid   = Lib_Request::get('appid');
        $apiid   = Lib_Request::get('apiid');
        $address = Lib_Request::get('address');
        $data    = array(
            'id'      => 0,
            'appid'   => $appid,
            'api_id'  => intval($apiid),
            'address' => $address,
            'order'   => 99,
            'timeout' => 3,
            'connection_timeout' => 3,
            'keep_session'       => 1,
            'request_params'     => array(),
        );
        if (!empty($id)) {
            $result = Instance::table($this->bindTableName)->getOne("*", array('id' => $id));
            if (!empty($result)) {
                $data = array_merge($data, $result);
                $data['request_params'] = json_decode($data['request_params'], true);
            }
        } elseif (!empty($apiid)) {
            $api = Model_Api_Api::instance()->getApiInfoById($apiid);
            if (!empty($api)) {
                $data['name']           = "{$api['name']} 的测试";
                $data['request_method'] = $api['content']['request_type'];
                if (!empty($api['content']['request_params'])) {
                    foreach ($api['content']['request_params'] as $k => $v) {
                        $data['request_params'][$v['name']] = $v['example'];
                    }
                }
                $this->assign('api', $api);
            }
        }
        $this->assigns(array(
            'data'    => $data,
            'apiList' => Model_Api_Api::instance()->getApiTreeByAppId($appid),
            'methods' => Module_Api::instance()->methods,
            'mainTpl' => 'api/test/item',
        ));
        $this->display();
    }

    /**
     * 异步执行接口测试请求
     */
    public function ajaxRequest()
    {
        $data = Lib_Request::getPostArray(array(), true);
        if (!empty($this->_session['user'])) {
            $data['uid'] = $this->_session['user']['uid'];
        }
        $params = $this->_parseRequestParams($data['request_params']);
        $http   = new Lib_Network_Http();
        $http->setBrowserMode(true);
        if (!empty($data['timeout'])) {
            $http->setTimeout($data['timeout']);
        }
        if (!empty($data['connection_timeout'])) {
            $http->setConnectionTimeout($data['connection_timeout']);
        }
        if (!empty($this->_session['api_test']['cookie'])) {
            $http->setCookie($this->_session['api_test']['cookie']);
        }
        $result = $http->send($data['address'], $params, $data['request_method'], 1);
        $cookie = $http->getCookie();
        $cookie = trim($cookie);
        if (!empty($cookie)) {
            $this->_session['api_test'] = array(
                'cookie' => $cookie,
            );
        }
        $data['response_content_raw'] = $http->httpHeaderContent.$result;
        $data['response_content']     = $result;
        if (!empty($data['uid']) && !empty($data['name'])) {
            $testId = Instance::table($this->bindTableName)->getValue('id', array('uid' => $data['uid'], 'name' => $data['name']));
            if (empty($testId)) {
                $data['create_time'] = time();
            } else {
                $data['id'] = $testId;
            }
            $data['request_params'] = json_encode($params);
            $data['update_time']    = time();
            Instance::table($this->bindTableName)->mysqlFiltSave($data);
        }
        $response = array(
            'response_content_raw' => $data['response_content_raw'],
            'response_content'     => $data['response_content'],
        );
        // 将json中的unicode转换为中文
        if (Lib_Validator::checkRule($response['response_content'], 'json')) {
            $response['response_content'] = json_encode(json_decode($response['response_content'], true), JSON_UNESCAPED_UNICODE);
        }
        Lib_Response::json(true, $response);
    }

    /**
     *
     * 将页面提交的请求参数转换为服务端所需使用的请求参数格式.
     *
     * @param array $requestParams 页面提交的请求参数.
     *
     * @return array
     */
    private function _parseRequestParams(array $requestParams)
    {
        $params = array();
        $requestParamNames    = $requestParams['name'];
        $requestParamContents = $requestParams['content'];
        foreach ($requestParamNames as $k => $v) {
            $v = trim($v);
            if (empty($v)) {
                continue;
            }
            $params[$v] = $requestParamContents[$k];
        }
        return $params;
    }

    /**
     * 异步列表排序.
     *
     * @return void
     */
    public function ajaxSort()
    {
        $ids = Lib_Request::getPost('ids');
        foreach ($ids as $k => $id) {
            Instance::table($this->bindTableName)->update(
                array('order' => $k + 1),
                array(
                    'id'  => $id,
                    'uid' => $this->_session['user']['uid']
                )
            );
        }
        Lib_Response::json(1);
    }

    /**
     * 异步删除接口测试.
     */
    public function ajaxDelete()
    {
        $id = Lib_Request::get('id', 0);
        if (!empty($id)) {
            Instance::table($this->bindTableName)->delete(array('id' => $id));
        }
        Lib_Response::json(1, '', '接口删除成功');
    }

}
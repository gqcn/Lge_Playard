<?php
namespace Lge;

if(!defined('LGE')){
    exit('Include Permission Denied!');
}

class Controller_Test extends BaseController
{
    public function index()
    {
//        $str = 'regix_e:/[\y\w].:[\d\w]+/i';
//        $str = 'required|regex:/|[\y\w].:[\d\w]+/i|min:2,3|regex:/|[\y\w].:2[\d\w]+/i';
//        // preg_match("/^(\w+)(:*)(.+)/", $str, $match);
//        $r = preg_match_all("/(regex:(\/.+?\/\w*))/", $str, $match);
//        var_dump($r);
//        print_r($match);
//
//        exit();
        $data  = array(
            'username'  => '1',
            'userpass'  => '1234567',
            'userpass2' => '123456',
        );
// 规则格式1
        $rules = array(
            'username'  => 'required',
            'userpass'  => array('required', '用户密码不能为空'),
            'userpass2' => array('required|same:userpass', array('请再次输入密码进行确认', '您两次输入的密码不一致')),
        );

// 规则格式2
        $rules = array(
            'username'  => 'required',
            'userpass'  => array('required', '用户密码不能为空'),
            'userpass2' => array('regex:/[^0-9]+/|regex:/[^0-9]+/i', array('您两次输入的密码不一致', '123')),
        );
        $result = Lib_Validator::check($data, $rules, 1, false);
print_r($result);
    }
}

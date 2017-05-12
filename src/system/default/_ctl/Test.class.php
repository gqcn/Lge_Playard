<?php
namespace Lge;

if(!defined('LGE')){
    exit('Include Permission Denied!');
}

class Controller_Test extends BaseController
{
    public function index()
    {
        var_dump(Lib_Validator::checkRule('{"result":1,"message":"","data":[{"rule_key":"login","score":5,"create_time":1494560516,"alias":"\u6bcf\u5929\u9996\u6b21\u767b\u5f55"},{"rule_key":"register","score":100,"create_time":1494559513,"alias":"\u6ce8\u518c\u6210\u529f"},{"rule_key":"certification","score":100,"create_time":1494559513,"alias":"\u5b9e\u540d\u4fe1\u606f\u8ba4\u8bc1"},{"rule_key":"join_community","score":50,"create_time":1494559513,"alias":"\u6210\u529f\u52a0\u5165\u4e91\u793e\u533a"}]}', 'json'));
    }
}

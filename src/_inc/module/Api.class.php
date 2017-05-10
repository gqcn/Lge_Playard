<?php
namespace Lge;

if (!defined('LGE')) {
    exit('Include Permission Denied!');
}

/**
 * 接口管理模块。
 */
class Module_Api extends BaseModule
{
    /*
     * 状态数组
     *
     * @array
     */
    public $statuses = array(
        0 => '未开始',
        1 => '进行中',
        2 => '已完成',
    );

    /*
     * 请求方式数组
     */
    public $methods = array(
        'GET'    => 'GET',
        'PUT'    => 'PUT',
        'POST'   => 'POST',
        'DELETE' => 'DELETE',
        // 'SOCKET' => 'SOCKET',
    );

    /*
     * 参数类型
     * @var array
     */
    public $paramTypes = array(
        'string'   => 'String (字符串)',
        'integer'  => 'Integer (整数)',
        'float'    => 'Float (小数)',
        'double'   => 'Double (小数)',
        'boolean'  => 'Boolean (布尔值)',
        'binary'   => 'Binary (二进制)',
        'array'    => 'Array (数组)',
        'object'   => 'Object (对象)',
    );

    /*
     * 参数状态
     * @var array
     */
    public $paramStatuses = array(
        'required'  => 'Required (必填)',
        'optional'  => 'Optional (选填)',
        'constant'  => 'Constant (常量)',
    );

    /**
     * 获得实例.
     *
     * @return Module_Api
     */
    public static function instance()
    {
        return self::_instanceInternal(__CLASS__);
    }

}

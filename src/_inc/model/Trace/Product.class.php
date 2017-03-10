<?php
namespace Lge;

if(!defined('LGE')){
    exit('Include Permission Denied!');
}
/**
 * 溯源系统 - 产品管理.
 *
 */
class Model_Trace_Product extends BaseModelTable
{
    public $table = 'plugin_trace_product';

    /**
     * 获得实例.
     *
     * @return Model_Trace_Product
     */
    public static function instance()
    {
        return self::instanceInternal(__CLASS__);
    }

    /**
     * 生成一个唯一的批次编号.
     *
     * @return string
     */
    public function makeUniqueBatchNo()
    {
        $no = time();
        for ($i = 0; $i < 6; $i++) {
            $no .= rand(0, 9);
        }
        $no = base_convert($no, 10, 36);
        $no = strtoupper($no);
        return $no;
    }
}
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
     * 根据产品编码查询产品信息.
     *
     * @param string $productNo 产品编码.
     * @return array
     */
    public function getProductInfoByProductNo($productNo)
    {
        $batchNo = substr($productNo, 0, 10);
        $number  = substr($productNo, 10);
        $number  = base_convert($number, 36, 10);
        $data    = $this->getOne("*", array('batch_no' => $batchNo));
        if (!empty($data) && $data['number'] >= $number) {
            $contentFlow = empty($data['content_flow']) ? $data['content_flow'] : json_decode($data['content_flow'], true);
            if (!empty($contentFlow)) {
                $data['content_flow'] = array();
                $data['product_flow'] = Instance::table('_plugin_trace_flow')->getAll(
                    "*", array('cat_id' => $data['cat_id']), null, "`order`,id asc", 0, 0, 'id'
                );
                if (!empty($data['product_flow'])) {
                    foreach ($data['product_flow'] as $flowId => $item) {
                        if (isset($contentFlow[$flowId])) {
                            $data['content_flow'][$flowId] = $contentFlow[$flowId];
                        }
                        $data['content_flow'][$flowId]['name'] = $item['name'];
                    }
                }
            }
        }
        return $data;
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
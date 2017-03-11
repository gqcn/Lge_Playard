<?php
namespace Lge;

if (!defined('LGE')) {
	exit('Include Permission Denied!');
}

class Controller_Default extends Controller_Base
{
    
    /**
     * 首页.
     */
    public function index()
    {
        $productNo   = Lib_Request::get('no');
        $productInfo = empty($productNo) ? array() : Model_Trace_Product::instance()->getProductInfoByProductNo($productNo);
        $title       = empty($productInfo) ? '溯源查询：查无此产品' : "溯源查询：{$productInfo['name']}";
        $this->assigns(array(
            'data'         => $productInfo,
            'title'        => $title,
            'containerTpl' => '_trace/product',
        ));
        $this->display();
    }
}
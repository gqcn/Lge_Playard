<?php
namespace Lge;

if (!defined('LGE')) {
	exit('Include Permission Denied!');
}

class Controller_Trace_Default extends Controller_Base
{
    
    /**
     * 首页.
     */
    public function index()
    {
        $productNo   = Lib_Request::get('no');
        $productInfo = empty($productNo) ? array() : Model_Trace_Product::instance()->getProductInfoByProductNo($productNo);
        $this->assigns(array(
            'data'         => $productInfo,
            'productNo'    => strtoupper($productNo),
            'title'        => '防伪溯源系统',
            'containerTpl' => '_trace/product',
        ));
        $this->display();
    }
}
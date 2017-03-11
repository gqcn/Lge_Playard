<?php
namespace Lge;

if(!defined('LGE')){
    exit('Include Permission Denied!');
}

class Controller_Base extends BaseController
{
    public  $startSession = true;    // 是否开启session
    public  $sessionID    = null;    // 设置session id

    /**
     * 获得分页的start
     *
     * @param  int    $perPage
     * @param  string $pageName
     * @return int
     */

    public function getStart($perPage, $pageName = 'page')
    {
        $curPage = isset($this->_get[$pageName]) ? intval($this->_get[$pageName]) : 0;
        if ($curPage > 1) {
            $start = ($curPage - 1)*$perPage;
        } else {
            $start = 0;
        }
        return $start;
    }

    /**
     * 封装：MVC显示页面。
     *
     */
    public function display($tpl = 'index')
    {
        $this->assigns(array(
            'config'  => Config::get(),
            'session' => $this->_session,
            'system'  => '/system/trace_default/',
        ));
        parent::display($tpl);
    }
}
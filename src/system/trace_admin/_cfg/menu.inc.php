<?php
/**
 * 后台管理菜单列表，注释项为未正式发布功能。
 *
 * 1. 菜单最多为三级；
 * 2. 第一级和最后一级菜单可以带icon标签，表示图标；
 * 3. 菜单格式：
    array(
        'name' => 菜单名字,
        'icon' => 菜单前的小图标(来源于font awesome),
        'acts' => 对应的控制器方法名称,
        'url'  => 跳转链接,
        'subs' => 子级菜单数组,
    ),
 *
 * @var array
 */
return array(
    array(
        'name' => '系统首页',
        'icon' => 'menu-icon fa fa-home',
        'acts' => array('default', 'index'),
        'url'  => '/default',
    ),

    array(
        'name' => '系统管理',
        'icon' => 'menu-icon fa fa-cogs',
        'subs' => array(
            array(
                'name' => '操作日志',
                'acts' => array('operation-log', 'index'),
                'url'  => '/operation-log/index',
            ),
            array(
                'name' => '文件管理',
                'acts' => array('setting', 'filemanager'),
                'url'  => '/setting/filemanager',
            ),
        ),
    ),

    array(
        'name' => '产品管理',
        'icon' => 'menu-icon fa fa-cubes',
        'subs' => array(
            array(
                'name' => '产品分类',
                'acts' => array('trace.category', 'index'),
                'url'  => '/trace.category/index',
            ),
            array(
                'name' => '产品流程',
                'acts' => array('trace.flow', 'index'),
                'url'  => '/trace.flow/index',
            ),
            array(
                'name' => '产品管理',
                'acts' => array('trace.product', 'index'),
                'url'  => '/trace.product/index',
            ),
        ),
    ),

    array(
        'name' => '用户管理',
        'icon' => 'menu-icon fa fa-group',
        'subs' => array(
            array(
                'name' => '添加用户',
                'acts' => array('user', 'item'),
                'url'  => '/user/item',
            ),
            array(
                'name' => '用户查询',
                'acts' => array('user', 'index'),
                'url'  => '/user',
            ),

            array(
                'name' => '添加用户组',
                'acts' => array('user-group', 'item'),
                'url'  => '/user-group/item',
            ),

            array(
                'name' => '用户组管理',
                'acts' => array('user-group', 'index'),
                'url'  => '/user-group',
            ),
        ),
    ),
);


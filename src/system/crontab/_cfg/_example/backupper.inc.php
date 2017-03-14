<?php
/**
 * 服务器备份配置.
 *
 */
return array(
    // 存放备份数据及文件的客户端信息(通过SSH远程登录客户端执行配备文件的写入)
    'backup_client' => array(
        'host'    => 'johnx.cn',
        'port'    => '8822',
        'user'    => 'john',
        'pass'    => '',
        'folder'  => '/home/john/Backup/',
    ),
    // 需要备份的服务器信息
    'backup_server' => array(

    ),
);
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
        /*
        '备份项名称' => array(
            // MySQL数据库备份
            'data' => array(
                array(
                    'host'  => '127.0.0.1',
                    'port'  => '3306',
                    'user'  => 'root',
                    'pass'  => '123456',
                    'names' => array(
                        // 数据库名称 => 本地备份文件保存天数
                        'lge_playard' => 7,
                    ),
                ),
            ),
            // 服务器目录备份
            'file' => array(
                array(
                    'host'    => '127.0.0.1',
                    'port'    => '22',
                    'user'    => 'root',
                    'pass'    => '123456',
                    'folders' => array(
                        // 服务器备份目录绝对路径 => 本地备份文件保存天数，大于0有效，否则只保留增量的目录
                        '/etc/' => 3,
                    ),
                ),
            ),
        ),
        */
    ),
);
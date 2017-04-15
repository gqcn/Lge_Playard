<?php
namespace Lge;

if(!defined('LGE')){
	exit('Include Permission Denied!');
}

/**
 * Git方式自动部署程序到服务器。
 * 使用说明：
 * 1、项目客户端应当已经保存密码;
 * 2、如果是ssh push那么应当保证客户端与服务端已经通过ssh的authorized_keys授权，或者，安装sshpass工具，并在配置文件中对服务器指定密码；
 * 2、在项目根目录下执行；
 */
class Controller_GitDeploy extends Controller_Base
{
    public function index()
    {
        $pwd = $this->_server['PWD'];
        if (empty($pwd)) {
            echo "当前工作目录地址不能为空！\n";
            exit();
        }
        $option       = Lib_ConsoleOption::instance();
        $deployKey    = $option->getOption('key', 'default');
        $deployConfig = $option->getOption('config');
        if (!empty($deployConfig) && file_exists($deployConfig)) {
            $configArray = include($deployConfig);
            $deployArray = isset($configArray[$deployKey]) ? $configArray[$deployKey] : array();
        } else {
            $deployArray = Config::get($deployKey, 'git-deploy', true);
        }
        if (empty($deployArray)) {
            echo "找不到\"{$deployKey}\"对应的配置项！\n";
            exit();
        } else {
            chdir($pwd);
            foreach ($deployArray as $k => $item) {
                $resp   = $item[0];
                $branch = empty($deployBranch) ? $item[1] : $deployBranch;
                if (empty($item[2])) {
                    $cmd = "git push {$resp} {$branch}";
                } else {
                    $cmd = "sshpass -p {$item[2]} git push {$resp} {$branch}";
                }
                echo ($k + 1).": {$resp} {$branch}\n";
                exec($cmd);
                echo "\n";
            }
        }
    }
}

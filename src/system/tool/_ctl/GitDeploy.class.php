<?php
namespace Lge;

if(!defined('LGE')){
	exit('Include Permission Denied!');
}

/**
 * Git方式自动部署程序到服务器。
 * 使用说明：
 * 1、项目客户端应当已经保存密码，如果是ssh push那么应当保证客户端与服务端已经通过ssh的authorized_keys授权；
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
        $deployKey    = $option->getOption('key');
        $deployBranch = $option->getOption('branch');
        $deployArray  = Config::get($deployKey, 'git-deploy', true);
        if (empty($deployArray)) {
            echo "找不到\"{$deployKey}\"对应的配置项！\n";
            exit();
        } else {
            chdir($pwd);
            foreach ($deployArray as $k => $item) {
                $resp   = $item[0];
                $branch = empty($deployBranch) ? $item[1] : $deployBranch;
                $cmd    = "git push {$resp} {$branch}";
                echo ($k + 1).": {$cmd}\n";
                exec($cmd);
                echo "\n";
            }
        }
    }
}

<?php
namespace Lge;

if(!defined('LGE')){
	exit('Include Permission Denied!');
}

class Controller_Test extends BaseController
{

    /**
     * 用于设置社长账户当前状态
     * @param type $uid 用户id
     * @param type $status 社长当前账户状态
     */
    public function setAccountStatus(){


        $data   = Lib_Request::getPostArray(array(
            'uid'            => 0,
            'status'         => 2,
            'contract_no'    => '',
            'from_type'      => '',
        ));
        $uid = $data["uid"];
        $status = $data["status"];
        $contractNo = $data["contract_no"];
        $mobile = Instance::table('_user_detail')->getValue("phone", array("uid" => $uid));
        switch($data["status"]){


            //激活成功，社区编号和手机号绑定成功，更新用户贡献值记录
            case 1:
                if(Instance::table('_community_user')->update(array('status' => $status,'contract_no' => $contractNo),"uid={$uid}")){
                    $this->addMessage('已经成功激活', 'success');
                    $code = '#loginurl#=www.gdgyun.com';
                    $isSend = Module_Sms::instance()->send([$mobile=>$uid],$code,31286);
                    $contributionModule=Module_Contribution::instance();
                    $contributionModule->checkContributionRule("account_activite",$uid,$data["from_type"]);
                }else{
                    $this->addMessage('未成功激活', 'error');
                }

                break;
            //打回重填，发送短信，跳转至社长账号列表页面
            case 3:
                if(Instance::table('_community_user')->update(array('status' => $status),"uid={$uid}")){
                    $this->addMessage('已经成功打回', 'success');
                    $code = '#loginurl#=www.gdgyun.com';
                    $isSend = Module_Sms::instance()->send([$mobile=>$uid],$code,31285);
                }else{
                    $this->addMessage('打回失败', 'error');
                }
                break;

        }
        //发送短信给用户
        if($isSend['errorCode']>0){
            $this->addMessage('短信发送失败!', 'error');

        }else{
            $this->addMessage('短信发送成功!', 'success');
        }
        Lib_Redirecter::redirect("community");



    }

    public function index()
    {
        $connection = \ssh2_connect('127.0.0.1', 22);
        ssh2_auth_password($connection, 'john', '8692651');

        $stream = ssh2_exec($connection, 'php -a');
        stream_set_blocking($stream, true );
        while (true) {
            $r = stream_get_contents($stream);
            var_dump($r);
            if (feof($stream)) {
                exit();
            }
            sleep(1);
        }


        exit();
        $db    = Instance::database('johnx.cn');
        $table = Instance::table('wp_posts', 'johng.cn');
        $sql   = "select pa.title,pa.time,pc.content from phpme_article pa 
                left join phpme_content pc on(pc.tid=pa.id and pc.mode='article')";
        $list = $db->getAll($sql);
        foreach ($list as $v) {
            $data = array(
                'post_author'   => 1,
                'post_date'     => $v['time'],
                'post_date_gmt' => $v['time'],
                'post_content'  => $v['content'],
                'post_title'    => $v['title'],
                'post_status'   => 'publish',
                'comment_status'    => 'open',
                'ping_status'       => 'open',
                'post_name'         => date('YmdHis', strtotime($v['time'])),
                'post_modified'     => $v['time'],
                'post_modified_gmt' => $v['time'],
                'post_parent'       => '230',
                'post_type'         => 'post',
            );
            $table->insert($data);
        }
    }
}

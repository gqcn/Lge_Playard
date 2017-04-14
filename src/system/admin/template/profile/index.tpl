<div class="row">
<div class="col-xs-12">


<div class="col-xs-12 col-sm-3 center">
<div>
    <span class="profile-picture">
        <a href="javascript:{if !$_Get->data['view']}changeAvatar(){/if};" >
        <img src="{$_Session->data['user']['avatar']}" style="width:180px;height:200px;" id="avatar"/>
        </a>
        <div>头像预览</div>
    </span>
</div>                 
</div>

<div class="col-xs-12 col-sm-9">
    <form class="form-horizontal" id="validation-form" action="?app=profile&act=edit" method="post">
    <input value="{$_Session->data['user']['avatar']}" type="hidden" name="avatar"/>
        <div class="form-group">
            <label class="control-label col-xs-12 col-sm-2 no-padding-right">帐号:</label>
            <div class="col-xs-12 col-sm-9">
                <div class="clearfix">
                    <input value="{$_Session->data['user']['passport']}" type="text" name="passport" class="col-xs-12 col-sm-12" readonly="true" style="width:300px;"/>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-12 col-sm-2 no-padding-right">昵称:</label>
            <div class="col-xs-12 col-sm-9">
                <div class="clearfix">
                    <input value="{$_Session->data['user']['nickname']}" type="text" name="nickname" class="col-xs-12 col-sm-12" style="width:300px;"/>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-xs-12 col-sm-2 no-padding-right">状态:</label>

            <div class="col-xs-12 col-sm-9">
            <div style="padding-top:5px;">
            {if $_Session->data['user']['status'] == 1}
            <span class="lbl green"> 正常</span>
            {else}
            <span class="lbl red"> 禁用</span>
            {/if}
            </div>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-xs-12 col-sm-2 no-padding-right">性别:</label>

            <div class="col-xs-12 col-sm-9" style="padding-top:2px;">
                <div>
                    <label>
                        <input name="gender" value="1" type="radio" class="ace" {if $_Session->data['user']['gender'] == 1}checked{/if}/>
                        <span class="lbl blue"> 男士</span>
                    </label>

                    <label>
                        <input name="gender" value="0" type="radio" class="ace" {if $_Session->data['user']['gender'] == 0}checked{/if}/>
                        <span class="lbl blue"> 女士</span>
                    </label>
                </div>

            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-xs-12 col-sm-2 no-padding-right">邮箱:</label>
            <div class="col-xs-12 col-sm-9">
                <div class="clearfix">
                    <input value="{$_Session->data['user']['email']}" type="text" name="email" class="col-xs-12 col-sm-12" style="width:300px;"/>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-xs-12 col-sm-2 no-padding-right">手机:</label>
            <div class="col-xs-12 col-sm-9">
                <div class="clearfix">
                    <input value="{$_Session->data['user']['mobile']}" type="text" name="mobile" class="col-xs-12 col-sm-12" style="width:300px;"/>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-xs-12 col-sm-2 no-padding-right">电话:</label>
            <div class="col-xs-12 col-sm-9">
                <div class="clearfix">
                    <input value="{$_Session->data['user']['telephone']}" type="text" name="telephone" class="col-xs-12 col-sm-12" style="width:300px;"/>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-xs-12 col-sm-2 no-padding-right">QQ:</label>
            <div class="col-xs-12 col-sm-9">
                <div class="clearfix">
                    <input value="{$_Session->data['user']['qq']}" type="text" name="qq" class="col-xs-12 col-sm-12" style="width:300px;"/>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-xs-12 col-sm-2 no-padding-right">总共配额:</label>
            <div class="col-xs-12 col-sm-9">
                <div class="clearfix">
                    <input value="{$_Session->data['user']['quota_total_format']}" type="text" class="col-xs-12 col-sm-12" readonly="true" style="width:300px;"/>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-xs-12 col-sm-2 no-padding-right">已用配额:</label>
            <div class="col-xs-12 col-sm-9">
                <div class="clearfix">
                    <input value="{$_Session->data['user']['quota_used_format']}" type="text" class="col-xs-12 col-sm-12" readonly="true" style="width:300px;"/>
                </div>
            </div>
        </div>
        

        <div class="form-group">
            <label class="control-label col-xs-12 col-sm-2 no-padding-right">注册时间:</label>
            <div class="col-xs-12 col-sm-9">
                <div class="clearfix">
                    <input value="{$_Time->format($_Session->data['user']['register_time'])}" type="text" readonly="true" class="col-xs-12 col-sm-12" style="width:300px;"/>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-xs-12 col-sm-2 no-padding-right">最近登陆:</label>
            <div class="col-xs-12 col-sm-9">
                <div class="clearfix">
                    <input value="{if $_Session->data['user']['last_login_time']}{$_Time->format($_Session->data['user']['last_login_time'])}{/if}" type="text" readonly="true" class="col-xs-12 col-sm-12" style="width:300px;"/>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-xs-12 col-sm-2 no-padding-right">注册IP:</label>
            <div class="col-xs-12 col-sm-9">
                <div class="clearfix">
                    <input value="{$_Session->data['user']['register_ip']}" type="text" readonly="true" class="col-xs-12 col-sm-12" style="width:300px;"/>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-xs-12 col-sm-2 no-padding-right">最近登陆IP:</label>
            <div class="col-xs-12 col-sm-9">
                <div class="clearfix">
                    <input value="{$_Session->data['user']['last_login_ip']}" type="text" readonly="true" class="col-xs-12 col-sm-12" style="width:300px;"/>
                </div>
            </div>
        </div>

        
        <div class="form-group">
            <label class="control-label col-xs-12 col-sm-2 no-padding-right">地址:</label>
            <div class="col-xs-12 col-sm-9">
                <div class="clearfix">
                    <input value="{$_Session->data['user']['address']}" type="text" name="address" class="col-xs-12 col-sm-12"/>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-12 col-sm-2 no-padding-right">说明:</label>
            <div class="col-xs-12 col-sm-9">
                <div class="clearfix">
                    <textarea name="brief" style="height:100px;width:100%;">{$_Session->data['user']['brief']}</textarea>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-12 col-sm-2 no-padding-right"></label>
            <div class="col-xs-12 col-sm-9">
                <div class="clearfix">
                    <button class="btn btn-info" type="submit">
                    <i class="icon-ok bigger-110"></i>
                    保存&nbsp;&nbsp;&nbsp;
                    </button>
                </div>
            </div>
        </div>

    </form>
</div>
</div>
</div>

<!-- elfinder -->
<link rel="stylesheet" href="/plugin/elfinder_2_0_rc1/jquery/ui-themes/smoothness/jquery-ui-1.8.18.custom.css">
<link rel="stylesheet" href="/plugin/elfinder_2_0_rc1/css/elfinder.min.css">
<script src="/plugin/elfinder_2_0_rc1/js/elfinder.all.min.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">
//修改头像
function changeAvatar() {
    showFileManager("选择新的头像", function(files){
        $("#avatar").attr('src', files);
        $("input[name='avatar']").val(files);
    }, ['image']);  
}

jQuery(function($) {

    $(".select2").css('width','300px').select2({allowClear:true})
    .on('change', function(){
        $(this).closest('form').validate().element($(this));
    }); 

});
</script>























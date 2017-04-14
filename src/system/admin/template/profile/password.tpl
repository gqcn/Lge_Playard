
<div class="row">
<div class="col-xs-12">
<form class="form-horizontal" id="validation-form" action="?app=profile&act=resetPassword" method="post">
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2 no-padding-right required">当前密码:</label>
        <div class="col-xs-12 col-sm-9">
            <div class="clearfix">
                <input value="" type="password" name="old_password" class="col-xs-12 col-sm-12" style="width:305px;"/>
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2 no-padding-right required">设置新密码:</label>
        <div class="col-xs-12 col-sm-9">
            <div class="clearfix">
                <input value="" type="password" name="new_password" id="new_password" class="col-xs-12 col-sm-12" style="width:305px;"/>
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2 no-padding-right required">确认新密码:</label>
        <div class="col-xs-12 col-sm-9">
            <div class="clearfix">
                <input value="" type="password" name="new_password2" class="col-xs-12 col-sm-12" style="width:305px;"/>
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

<script src="resource/js/md5-min.js"></script>
    
<script type="text/javascript">

jQuery(function($) {
    $('#validation-form').validate({
        errorElement: 'div',
        errorClass: 'help-block',
        focusInvalid: true,
        rules: {
        	old_password: {
                required: true
            },
            new_password: {
            	required: true
            },
            new_password2: {
            	required: true,
                equalTo: "#new_password"
            }
        },
        messages: {
        	old_password: {
                required: "请输入当前密码"
            },
            new_password: {
            	required: "请输入新的密码"
            },
            new_password2: {
            	required: "请再输入一遍新的密码确认",
            	equalTo: "两次输入的新密码不相等"
            }
        },
        submitHandler: function(form) {
            $("input[name='old_password']").val(hex_md5($("input[name='old_password']").val()));
            $("input[name='new_password']").val(hex_md5($("input[name='new_password']").val()));
            $("input[name='new_password2']").val(hex_md5($("input[name='new_password2']").val()));
            $(form).ajaxSubmit();
        },
        highlight: function (e) {
            $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
        },

        success: function (e) {
            $(e).closest('.form-group').removeClass('has-error').addClass('has-info');
            $(e).remove();
        },

        errorPlacement: function (error, element) {
            if(element.is(':checkbox') || element.is(':radio')) {
                var controls = element.closest('div[class*="col-"]');
                if(controls.find(':checkbox,:radio').length > 1) {
                    controls.append(error);
                } else {
                    error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
                }
            } else if(element.is('.select2')) {
                error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
            } else if(element.is('.chosen-select')) {
                error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
            } else {
                error.insertAfter(element.parent());
            }
        }
    });

});
</script>























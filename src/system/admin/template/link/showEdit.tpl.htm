<div class="row">
<div class="col-xs-12">
<form class="form-horizontal" id="validation-form" action="?app=link&act=edit" method="post" enctype="multipart/form-data">
<input type="hidden" name="link_id" value="{$data['link_id']}"/>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2 no-padding-right">连接分类:</label>
        <div class="col-xs-12 col-sm-9">
        {if $catArray}
        <select class="select2" name="cat_id">
            {foreach from=$catArray index=$index key=$key item=$item}
            <option value="{$item['cat_id']}" {if $data['cat_id'] == $item['cat_id']}selected{/if}>{$item['cat_name']}</option>
            {/foreach}
        </select>
        {else}
        <div style="margin:5px 0 0 0px;">当前没有连接分类，您可以点这 <a href="?app=link&act=category" target="_blank">创建分类</a></div>
        {/if}
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2 no-padding-right">连接排序:</label>
        <div class="col-xs-12 col-sm-9">
            <div class="clearfix">
                <input value="{$data['order']}" type="text" name="order" class="col-xs-12 col-sm-12" style="width:305px;"/>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2 no-padding-right required">连接标题:</label>
        <div class="col-xs-12 col-sm-9">
            <div class="clearfix">
                <input value="{$data['title']}" type="text" name="title" class="col-xs-12 col-sm-12" />
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2 no-padding-right required">连接地址:</label>
        <div class="col-xs-12 col-sm-9">
            <div class="clearfix">
                <input value="{$data['url']}" type="text" name="url" placeholder="http://" class="col-xs-12 col-sm-12" />
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2 no-padding-right" for="url">缩略图片: {if $data['thumb']}(<a href="{$data['thumb']}" target="_blank">查看</a>){/if}</label>
        <div class="col-xs-12 col-sm-9">
        <input value="{$data['thumb']}" name="thumb" type="text" class="col-xs-12 col-sm-12" placeholder="点击选择或上传连接的缩略图" onclick="showThumbSelection()"/>
        </div>
    </div>


    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2 no-padding-right">连接摘要:</label>
        <div class="col-xs-12 col-sm-9">
            <div class="clearfix">
                <textarea name="brief" style="height:150px;padding:5px 4px;" class="col-xs-12 col-sm-12" >{$data['brief']}</textarea>
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
                
                <button class="btn" type="button" onclick="window.location.href='?app={$_Get->data['app']}&act=index'">
                <i class="icon-reply bigger-110"></i>
                返回&nbsp;&nbsp;&nbsp;
                </button>
            </div>
        </div>
    </div>

</form>
</div>
</div>

{include _subinc/elfinder}
    
<script type="text/javascript">
// 显示缩略图上传/选择文件对话框
function showThumbSelection()
{
	showFileManager("缩略图选择", function(files){
		$("input[name=thumb]").val(files);
	}, ['image']);
}

jQuery(function($) {
	$(".select2").css('width','305px').select2({allowClear:true})
    .on('change', function(){
        $(this).closest('form').validate().element($(this));
    }); 

    $('#validation-form').validate({
        errorElement: 'div',
        errorClass: 'help-block',
        focusInvalid: true,
        rules: {
            title: {
                required: true
            },
            url: {
                required: true,
                url:true
            },
        },
        messages: {
            title: {
                required: "请输入连接标题"
            },
            url: {
                required: "请输入连接地址",
                url: "您输入的URL格式不正确"
            },
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























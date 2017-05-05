<div class="row">
<div class="col-xs-12">
<form class="form-horizontal" id="validation-form" action="?app=frag&act=edit" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2 no-padding-right">内容模型:</label>
        <div class="col-xs-12 col-sm-9">
        {if $models}
        <select class="select2" name="model_id">
            {foreach from=$models index=$index key=$key item=$item}
            <option value="{$item['model_id']}" {if $data['model_id'] == $item['model_id']}selected{/if}>{$item['model_name']}</option>
            {/foreach}
        </select>
        {else}
        <div style="margin:5px 0 0 0px;">当前还没有自定义的数据模型，您可以点这 <a href="?app=model&act=showEdit" target="_blank">创建模型</a></div>
        {/if}
        </div>
    </div>
    {if $data['fields']}
        {foreach from=$data['fields'] index=$index key=$key item=$item}
        <div class="form-group">
            <label class="control-label col-xs-12 col-sm-2 no-padding-right">{$item['field']['field_name']}:</label>
            <div class="col-xs-12 col-sm-8">
                <div class="clearfix">
                {if $item['field']['field_type'] == 'text'}
                    <input value="{$item['value']}" type="text" name="{$item['field']['field_key']}" id="{$item['field']['field_key']}" class="col-xs-12 col-sm-12"/>
                {elseif $item['field']['field_type'] == 'textarea'}
                    <textarea name="{$item['field']['field_key']}" id="{$item['field']['field_key']}" class="col-xs-12 col-sm-12" style="padding:6px 4px;height:100px;">{$item['value']}</textarea>
                {elseif $item['field']['field_type'] == 'radio'}
                    {if $item['field']['field_add_info']}
                    {foreach from=$item['field']['field_add_info'] key=$k item=$v}
                    <label><input value="{$v}" type="radio" name="{$item['field']['field_key']}"/> {$v}</label> 
                    {/foreach}
                    {/if}
                {elseif $item['field']['field_type'] == 'checkbox'}
                    {if $item['field']['field_add_info']}
                    {foreach from=$item['field']['field_add_info'] key=$k item=$v}
                    <label><input value="{$v}" type="checkbox" name="{$item['field']['field_key']}[]"/> {$v}</label> 
                    {/foreach}
                    {/if}
                {elseif $item['field']['field_type'] == 'select'}
                    {if $item['field']['field_add_info']}
                    <select  name="{$item['field']['field_key']}" style="width:300px;">
                    {foreach from=$item['field']['field_add_info'] key=$k item=$v}
                    <option value="{$v}">{$v}</option>
                    {/foreach}
                    </select>
                    {/if}
                {/if}
                </div>
            </div>
        </div>
        {/foreach}
    {/if}

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2 no-padding-right"></label>
        <div class="col-xs-12 col-sm-9">
            <div class="clearfix">
                <button class="btn btn-info" type="submit">
                <i class="icon-ok bigger-110"></i>
                保存&nbsp;&nbsp;&nbsp;
                </button>
                
                <button class="btn" type="button" onclick="window.location.href='?app={$_GET['app']}&act=index'">
                <i class="icon-reply bigger-110"></i>
                返回&nbsp;&nbsp;&nbsp;
                </button>
            </div>
        </div>
    </div>

</form>
</div>
</div>

<!-- elfinder -->
<link rel="stylesheet" href="/plugin/elfinder_2_0_rc1/jquery/ui-themes/smoothness/jquery-ui-1.8.18.custom.css">
<link rel="stylesheet" href="/plugin/elfinder_2_0_rc1/css/elfinder.min.css">
<script src="/plugin/elfinder_2_0_rc1/js/elfinder.all.min.js" type="text/javascript" charset="utf-8"></script>

<!-- ueditor -->
<script type="text/javascript" charset="utf-8" src="/plugin/ueditor1_3_6_2/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/plugin/ueditor1_3_6_2/ueditor.all.js"> </script>
<script type="text/javascript" charset="utf-8" src="/plugin/ueditor1_3_6_2/lang/zh-cn/zh-cn.js"></script>
    
    
<script type="text/javascript">

//显示添加媒体文件对话框
function showMediaSelection()
{
    showFileManager("添加/选择多媒体文件", function(files){
        addMediaToUEditor(files);
    });
}

jQuery(function($) {
	{* 编辑器判断 *}
    {if $data['fields']}
    {foreach from=$data['fields'] index=$index key=$key item=$item}
        {if $item['field']['field_add_type'] == 'editor'}
        UE.getEditor('{$item['field']['field_key']}');
        {/if}
    {/foreach}
    {/if}
    
    
    $('#validation-form').validate({
        errorElement: 'div',
        errorClass: 'help-block',
        focusInvalid: true,
        rules: {
            key: {
                required: true,
                remote: "?app=frag&act=asyncCheckKey&frag_id={$data['frag_id']}"
            },
            name: {
                required: true
            }
        },
        messages: {
            key: {
                required: "请输入碎片关键字"
            },
            name: {
                required: "请输入碎片名称"
            }
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























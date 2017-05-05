<style type="text/css">
.ModelField {margin:0 5px 0 0;}

</style>

<div id="HiddenField" style="display:none;">
    <div class="field">
        <div class="form-group">
            <label class="control-label col-xs-12 col-sm-2 no-padding-right">模型字段:</label>
            <div class="col-xs-12 col-sm-10">
                <div class="clearfix">
                    <input value="99" type="text" name="field_order[]" class="col-xs-12 ModelField" style="width:80px;" placeholder="字段排序"/>
                    <input value="" type="text" name="field_key[]" class="col-xs-12 ModelField" style="width:120px;" placeholder="字段key"/>
                    <input value="" type="text" name="field_name[]" class="col-xs-12 ModelField" style="width:120px;" placeholder="字段名称"/>
                    <input value="" type="text" name="default_value[]" class="col-xs-12 ModelField" style="width:120px;" placeholder="字段默认值"/>
                    <select name="field_type[]" class="ModelField" style="width:120px;">
                        <option value="text">单行文本</option>
                        <option value="textarea">多行文本</option>
                        <option value="radio">单项选择</option>
                        <option value="checkbox">多项选择</option>
                        <option value="select">列表选择</option>
                    </select>
                    <select name="field_add_type[]" class="ModelField" style="width:120px;">
                        <option value="">输入类型</option>
                        <option value="url">URL</option>
                        <option value="email">邮件</option>
                        <option value="number">数字</option>
                        <option value="digits">小数</option>
                        <option value="date">日期</option>
                        <option value="time">时间</option>
                        <option value="datetime">日期时间</option>
                        <option value="file">文件选择</option>
                        <option value="editor">富文本框</option>
                    </select>
                    <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons delete" style="display:inline !important;width:50px;">
                        <a href="javascript:;" class="red">
                            <i class="icon-minus bigger-130"></i> 删除
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-xs-12 col-sm-2 no-padding-right"></label>
            <div class="col-xs-12 col-sm-9">
                <textarea name="field_add_info[]" style="width:710px;" placeholder="附加参数，当字段类型为多选或者单选时，这里填写选择项，每一项用“|”分隔；当字段类型为单行或者多行文本时，这里填写输入提示信息。"></textarea>
            </div>
        </div>
    </div>
</div>

<div class="row">
<div class="col-xs-12">
<form class="form-horizontal" id="validation-form" action="?app=model&act=edit" method="post" onsubmit="return checkForm();">
<input type="hidden" name="model_id" value="{$data['model_id']}"/>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2 no-padding-right">模型信息:</label>
        <div class="col-xs-12 col-sm-10">
            <div class="clearfix">
                <input value="{$data['order']}" type="text" name="order" class="col-xs-12 ModelField" style="width:80px;" placeholder="模型排序"/>
                <input value="{$data['model_key']}" type="text" name="model_key" class="col-xs-12 ModelField" style="width:120px;" placeholder="模型key"/>
                <input value="{$data['model_name']}" type="text" name="model_name" class="col-xs-12 ModelField" style="width:120px;" placeholder="模型名称"/>
                <input value="{$data['brief']}" type="text" name="brief" class="col-xs-12 ModelField" style="width:375px;" placeholder="模型描述"/>
            </div>
        </div>
    </div>

    <div class="form-group" id="AppendBottom">
        <label class="control-label col-xs-12 col-sm-2 no-padding-right"></label>
        <div class="col-xs-12 col-sm-9">
            <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
                <a href="javascript:appendField('null')" class="green">
                    <i class="icon-plus bigger-130"></i> 添加字段
                </a>
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

    
<script type="text/javascript">
// 添加一个字段
function appendField(info)
{
	var fieldHtml  = $('#HiddenField').html();
	var fieldCount = $('.field').size();
	$('#AppendBottom').before(fieldHtml);
	$(".field:last label:first").html("模型字段" + fieldCount + ":");
	// 第一个字段是标题
    if (fieldCount == 1) {
    	$(".field:last input[name='field_order[]']").attr("readonly", true).val("0");
    	$(".field:last input[name='field_key[]']").attr("readonly", true).val("title");
    	$(".field:last input[name='field_name[]']").val("标题");
    	$(".field:last .delete").remove();
    }
    // 第二个字段是排序
    if (fieldCount == 2) {
        $(".field:last input[name='field_order[]']").attr("readonly", true).val("0");
        $(".field:last input[name='field_key[]']").attr("readonly", true).val("order");
        $(".field:last input[name='field_name[]']").val("排序");
        $(".field:last select[name='field_add_type[]']").val('number');
        $(".field:last .delete").remove();
    }
	// 添加内容
    if (info != 'null') {
    	$(".field:last input[name='field_order[]']").val(info.order);
    	$(".field:last input[name='field_key[]']").val(info.field_key);
    	$(".field:last input[name='field_name[]']").val(info.field_name);
    	$(".field:last input[name='default_value[]']").val(info.default_value);
        $(".field:last select[name='field_type[]']").val(info.field_type);
        $(".field:last select[name='field_add_type[]']").val(info.field_add_type);
        $(".field:last textarea[name='field_add_info[]']").html(info.field_add_info);
    }
	// 对新增的DOM添加点击删除事件
	$(".field:last .delete > a").click(function(){
		var obj = $(this).parents(".field");
	    bootbox.dialog({
	        message: "您确定删除该字段？",
	        buttons:            
	        {
	            "button" :
	            {
	                "label" : "取消",
	                "className" : "btn-sm"
	            },
	            "danger" :
	            {
	                "label" : "删除",
	                "className" : "btn-sm btn-danger",
	                "callback": function() {
	                	obj.remove();
	                }
	            }
	        }
	    });
    });
}

// 表单检查
function checkForm()
{
	var emptyFieldKeyCount  = 0;
	var emptyFieldNameCount = 0;
	$("input[name='field_key[]']").each(function(){
		if ($(this).val().length < 1) {
			emptyFieldKeyCount ++;
		}
    });
	$("input[name='field_name[]']").each(function(){
        if ($(this).val().length < 1) {
        	emptyFieldNameCount ++;
        }
    });
    // 检查模型信息
    if ($("input[name='model_key']").val().length < 1 || $("input[name='model_name']").val().length < 1) {
        bootbox.dialog({
            message: "模型信息不完整：模型Key和模型名称不能为空！",
            buttons:            
            {
                "danger" :
                {
                    "label" : "确定",
                    "className" : "btn-sm btn-danger"
                }
            }
        });
        return false;
    } else if (emptyFieldKeyCount > 1 || emptyFieldNameCount > 1) {
        bootbox.dialog({
            message: "模型字段信息不完整：字段Key和字段名称不能为空！",
            buttons:            
            {
                "danger" :
                {
                    "label" : "确定",
                    "className" : "btn-sm btn-danger"
                }
            }
        });
        return false;
    } else {
    	return true;
    }
}

jQuery(function($) {
    {if $data['fields']}
    {foreach from=$data['fields'] index=$index key=$key item=$item}
    appendField({$_String->jsonEncode($item)});
    {/foreach}
    {else}
    appendField('null');
    appendField('null');
    {/if}
});
</script>























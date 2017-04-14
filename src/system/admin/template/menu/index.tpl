<style type="text/css">
.table thead > tr > th, 
.table tbody > tr > th, 
.table tfoot > tr > th, 
.table thead > tr > td, 
.table tbody > tr > td, 
.table tfoot > tr > td  {vertical-align: middle;}

a{
hide-focus: expression(this.hideFocus=true);
outline: none;
}
</style>


<div class="row">
<div class="col-xs-12">

<form class="form-horizontal" id="CategorySortForm" action="?app=menu&act=sort" method="post">
<div style="margin:0 0 5px 0;">
<button class="btn btn-sm btn-success" href="#modal-form" data-toggle="modal" onclick="clearForm()"><i class="icon-plus bigger-110"></i>添加&nbsp;</button>

<select class="select2" name="cat_id" title="菜单分类" data-rel="tooltip" onchange="changeCategory(this.value)">
    <option value="0">所有分类</option>
    {if $catArray}
    {foreach from=$catArray index=$index key=$key item=$item}
    <option value="{$item['cat_id']}" {if $_Get->data['cat_id'] == $item['cat_id']}selected{/if}>{$item['cat_name']}</option>
    {/foreach}
    {/if}
</select>

</div>
<table id="sample-table-1" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:70px;">排序</th>
            <th style="width:80px;">菜单ID</th>
            <th>菜单Key</th>
            <th style="width:300px;">菜单名称</th>
            <th style="width:100px;">菜单类型</th>
            <th>菜单分组</th>
            <th>URL</th>
            <th>打开窗口</th>
            <th style="width:80px;" class="center">操作</th>
        </tr>
    </thead>

    <tbody>
    {if $menuArray}
        {foreach from=$menuArray index=$index key=$key item=$item}
        <tr menu_info='{$_String->jsonEncode($item)}' id="{$item['menu_id']}" cat_id="{$item['cat_id']}">
            <td>
            <input type="text" name="orders[{$item['menu_id']}]" style="width:50px;" value="{$item['order']}"/>
            </td>
            <td>{$item['menu_id']}</td>
            <td>{$item['menu_key']}</td>
            <td>{$item['menu_name']}</td>
            <td>{$item['type_name']}</td>
            <td>{$item['cat_name']}</td>
            <td>{if $item['url_name']}{$item['url_name']}{else}{$item['url']}{/if}</td>
            <td>{$item['target_name']}</td>
            <td class="center">
                <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
                    <a href="#modal-form" data-toggle="modal" onclick="editForm({$item['menu_id']})" class="green" title="修改" data-rel="tooltip">
                        <i class="icon-pencil bigger-130"></i>
                    </a>

                    <a href="javascript:deleteItem({$item['menu_id']});" class="red ButtonDelete" title="删除" data-rel="tooltip">
                        <i class="icon-trash bigger-130"></i>
                    </a>
                </div>
            </td>
        </tr>
        {/foreach}
    {/if}
    </tbody>
</table>
{if $menuArray}
<div style="margin:0;">
<button class="btn btn-sm btn-info" type="submit"><i class="icon-signal bigger-110"></i>排序</button>
</div>
{/if}
</form>

<div id="modal-form" class="modal" tabindex="-1">
<form class="form-horizontal" id="validation-form" action="?app=menu&act=edit" method="post">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="blue bigger">添加菜单</h4>
            </div>

            <div class="modal-body overflow-visible">
                <div class="row">
                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right">菜单类型:</label>
                            <div class="col-xs-12 col-sm-9">
                                <div class="clearfix">
                                <select name="type" style="width:200px;" onchange="changeMenuType(this.value)">
                                    <option value="0">内部连接</option>
                                    <option value="1">外部连接</option>
                                    <option value="2">模块连接</option>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right">父级菜单:</label>
                            <div class="col-xs-12 col-sm-9">
                                <div class="clearfix">
                                <select name="pmenu_id" style="width:200px;">
                                    <option value="0">作为顶级菜单</option>
                                        {if $menuArray}
                                            {foreach from=$menuArray index=$index key=$key item=$item}
                                            <option value="{$item['menu_id']}" pmenu_id="{$item['pmenu_id']}">{$item['menu_name']}</option>
                                            {/foreach}
                                        {/if}
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right">菜单分组:</label>
                            <div class="col-xs-12 col-sm-9">
                                <div class="clearfix">
                                <select name="cat_id" style="width:200px;">
                                    <option value="0">不分组菜单</option>
                                        {if $catArray}
                                            {foreach from=$catArray index=$index key=$key item=$item}
                                            <option value="{$item['cat_id']}" pcat_id="{$item['pcat_id']}">{$item['cat_name']}</option>
                                            {/foreach}
                                        {/if}
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right">菜单排序:</label>
                            <div class="col-xs-12 col-sm-9">
                            <div class="clearfix">
                                <input style="width:200px;" name="order" class="input-large" type="text" placeholder="序号越小,排序越靠前" value="99" />
                            </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right">菜单Key:</label>
                            <div class="col-xs-12 col-sm-9">
                                <div class="clearfix">
                                <input name="menu_key" style="width:250px;"  class="col-xs-12 col-sm-12" type="text" placeholder="使用在模板中" value="" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right required">菜单名称:</label>
                            <div class="col-xs-12 col-sm-9">
                                <div class="clearfix">
                                <input name="menu_name" style="width:250px;"  class="col-xs-12 col-sm-12" type="text" placeholder="" value="" />
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="form-group type_0">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right">内部连接地址:</label>
                            <div class="col-xs-12 col-sm-9">
                                <div class="clearfix">
                                <input name="url_0"  class="col-xs-12 col-sm-12" type="text" placeholder="内部连接地址以 ”/“ 开头" value="" />
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group type_1">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right">外部连接地址:</label>
                            <div class="col-xs-12 col-sm-9">
                                <div class="clearfix">
                                <input name="url_1"  class="col-xs-12 col-sm-12" type="text" placeholder="外部连接地址以 ”http://“ 路径开头" value="" />
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group type_2">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right">连接到模块:</label>
                            <div class="col-xs-12 col-sm-9">
                                <div class="clearfix">
                                    <select name="tcat_id" style="width:200px;">
                                            {if $modules}
                                                {foreach from=$modules index=$index key=$key item=$item}
                                                    <optgroup label="{$item['name']}">
                                                        {foreach from=$item['list'] index=$index key=$type item=$row}
                                                        <option value="{$row['cat_id']}">{$row['cat_name']}</option>
                                                        {/foreach}
                                                    </optgroup>
                                                {/foreach}
                                                
                                            {/if}
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right">打开窗口:</label>
                            <div class="col-xs-12 col-sm-9">
                                <div class="clearfix">
                                <select name="target" style="width:200px;">
                                    <option value="_self">原窗口</option>
                                    <option value="_blank">新窗口</option>
                                </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input name="menu_id" type="hidden" value="" />
                <button class="btn btn-sm" data-dismiss="modal" type="button"><i class="icon-remove"></i>取消</button>
                <button class="btn btn-sm btn-primary" type="submit"><i class="icon-ok"></i>保存</button>
            </div>
        </div>
    </div>
</form>
</div>
                                
                                
</div>
</div>



<script type="text/javascript">
// 显示分组过滤
function changeCategory(cat_id)
{
	if (cat_id > 0) {
		$("tr[cat_id]").hide();
	    $("tr[cat_id=" + cat_id + "]").show();
	} else {
		$("tr[cat_id]").show();
	}
}

// 选择菜单类型
function changeMenuType(type)
{
	$("div.type_" + type).show();
	for (var i = 0; i < 3; ++i) {
		if (i != type) {
			$("div.type_" + i).hide();
		}
	}
}

// 创建菜单时清空表单数据
function clearForm()
{
    var form = $("#validation-form");
    form.find("h4").html("添加菜单");
    form.find("select[name='type']").val(0);
    changeMenuType(0);
    form.find("select[name='pmenu_id']").val(0);
    form.find("select[name='pmenu_id']").find("option").removeAttr("disabled");
    form.find("select[name='cat_id']").val(0);
    form.find("input[name='menu_id']").val(0);
    form.find("input[name='order']").val(99);
    form.find("input[name='menu_key']").val('');
    form.find("input[name='menu_name']").val('');
    form.find("input[name='url_0']").val('');
    form.find("input[name='url_1']").val('');
    form.find("select[name='target']").val('_blank');
}

// 添加数据到表单中
function editForm(id)
{
    var menu = $.parseJSON($("tr[id=" + id + "]").attr("menu_info"));
    var form = $("#validation-form");
    form.find("h4").html("修改菜单");
    form.find("select[name='type']").val(menu.type);
    changeMenuType(menu.type);
    form.find("select[name='pmenu_id']").val(menu.pmenu_id);
    form.find("select[name='cat_id']").val(menu.cat_id);
    form.find("select[name='pmenu_id']").find("option").removeAttr("disabled");
    form.find("input[name='order']").val(menu.order);
    form.find("input[name='menu_name']").val(menu.old_name);
    form.find("input[name='url_0']").val(menu.url);
    form.find("input[name='url_1']").val(menu.url);
    form.find("input[name='menu_key']").val(menu.menu_key);
    form.find("input[name='menu_id']").val(menu.menu_id);
    form.find("select[name='target']").val(menu.target);
    form.find("select[name='tcat_id']").val(menu.tcat_id);
    // 自身以及子级不能作为自己的父级
    var menu_id = menu.menu_id;
    var select  = form.find("select[name='pmenu_id']");
    while (true) {
        select.find("option[value='" + menu_id + "']").attr('disabled', true);
        select.find("option[pmenu_id='" + menu_id + "']").attr('disabled', true);
        if (select.find("option[pmenu_id='" + menu_id + "']").length > 0) {
        	menu_id = select.find("option[pmenu_id='" + menu_id + "']").val();
        } else {
            break;
        }
    }
}

// 删除数据项
function deleteItem(id)
{
    var menu_info = $.parseJSON($("tr[id=" + id + "]").attr("menu_info"));
    var message   = "<div class='bigger-110'>确认删除该菜单: <font color=red>" + menu_info.menu_name + "</font>？</div>";
    message += "<div>注意: 如果菜单下有子级菜单, 该菜单将不能被删除!</div>";
    bootbox.dialog({
        message: message,
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
                    window.location.href='?app=menu&act=delete&menu_id=' + id
                }
            }
        }
    }); 
}

jQuery(function($) {
   $(".select2").css('width','180px').select2({allowClear:true})
    .on('change', function(){
        $(this).closest('form').validate().element($(this));
    }); 
	   
    $('#validation-form').validate({
        errorElement: 'div',
        errorClass: 'help-block',
        focusInvalid: true,
        rules: {
        	menu_name: {
                required: true
            }
        },
        messages: {
            menu_name: {
                required: "菜单名称不能为空"
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

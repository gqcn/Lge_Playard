<style type="text/css">
    html { overflow-x: hidden; overflow-y: auto; }
    #api-category-content {
        padding:0 5px 0 0;
    }
    #api-api-content {
        min-height:300px;
        padding:0 0 0 5px;
        border-left:1px solid #eee;
    }
    #api-category-table tr.sortable-placeholder {
        height:40px;
        border-style: dashed;
    }
    .category-td.active {
        font-weight:bold;
        font-size:14px;
    }
</style>


<div class="row">
    <div class="col-xs-12" style="padding:0 0 10px 0;">
        <div style="float:left;margin:0 10px 0 0;">
            <button href="#modal-form" data-toggle="modal" onclick="clearForm()" class="btn btn-sm btn-success" type="button" title="添加分类" data-rel="tooltip">
                <i class="ace-icon fa fa-plus bigger-110"></i>添加流程
            </button>
        </div>

        <div style="float:left;margin:0 10px 0 0;" title="请选择需要展示流程的分类" data-rel="tooltip">
            <select class="select3" name="catid" style="width:200px;">
                <option value="0" {if 0 == $_GET['catid']}selected{/if}>请选择需要展示流程的分类</option>
                {foreach from=$catList index=$index key=$key item=$item}
                    <option value="{$item['id']}" {if $item['id'] == $_GET['catid']}selected{/if}>{$item['name']}</option>
                {/foreach}
            </select>
        </div>
    </div>
    {if $list}
        <form class="form-horizontal" id="categoy-sort-form" action="/trace.flow/sort" method="post">
            <table id="api-category-table" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th style="width:70px;" class="center">排序</th>
                    <th>流程名称</th>
                    <th>流程说明</th>
                    <th>所属分类</th>
                    <th style="width:100px;" class="center">操作</th>
                </tr>
                </thead>
                <tbody>
                {foreach from=$list index=$index key=$key item=$item}
                    <tr item-info='{$_String->jsonEncode($item)}' item-id="{$item['id']}" item-pid="{$item['pid']}">
                        <td>
                            <input type="text" name="orders[{$item['id']}]" style="width:50px;" value="{$item['order']}"/>
                        </td>
                        <td>{$item['name']}</td>
                        <td>{$item['brief']}</td>
                        <td>{$item['cat_name']}</td>
                        <td class="center" >
                            <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons" style="margin-top:10px;">
                                <a href="#modal-form" data-toggle="modal" onclick="editForm({$item['id']})" class="green" title="修改" data-rel="tooltip">
                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                </a>
                                <a href="javascript:deleteItem('/trace.flow/delete?id={$item['id']}');" class="red ButtonDelete" title="删除" data-rel="tooltip">
                                    <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                {/foreach}
                </tbody>
            </table>

            <div style="margin:0;">
                <button class="btn btn-sm btn-info" type="submit"><i class="ace-icon fa fa-signal bigger-110"></i>排序</button>
            </div>
        </form>
    {elseif $_GET['catid']}
        该分类下暂无流程信息，请点击“添加流程”在该分类下添加流程。
    {else}
        请选择需要展示流程的分类。
    {/if}


    <div id="modal-form" class="modal" tabindex="-1">
        <form class="form-horizontal" id="flow-validation-form" action="/trace.flow/item" method="post">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="blue bigger">添加流程</h4>
                    </div>

                    <div class="modal-body overflow-visible">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12">
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-2 no-padding-right required">所属分类:</label>
                                    <div class="col-xs-12 col-sm-10">
                                        <div class="clearfix">
                                            <select name="cat_id" style="width:200px;">
                                                {if $catList}
                                                    {foreach from=$catList index=$index key=$key item=$item}
                                                        <option value="{$item['id']}" pid="{$item['pid']}" {if $item['id'] == $_GET['catid']}selected{/if}>
                                                            {$item['name']}
                                                        </option>
                                                    {/foreach}
                                                {/if}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-2 no-padding-right required">流程排序:</label>
                                    <div class="col-xs-12 col-sm-10">
                                        <div class="clearfix">
                                            <input name="order"  class="col-xs-12 col-sm-12" type="text" value="99" style="width:200px;"/>
                                            <span style="padding:7px 0 0 5px;display:block;">&nbsp;序号越小，排序越靠前</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-2 no-padding-right required">流程名称:</label>
                                    <div class="col-xs-12 col-sm-10">
                                        <div class="clearfix">
                                            <input name="name"  class="col-xs-12 col-sm-10" type="text" placeholder="请输入流程名称" value="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-2 no-padding-right">流程说明:</label>
                                    <div class="col-xs-12 col-sm-10">
                                        <div class="clearfix">
                                            <textarea name="brief" class="col-xs-12 col-sm-10" placeholder="关于该流程的简单描述" style="position: inherit;height:100px;padding:5px 4px;" ></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input name="id" type="hidden" value="" />
                        <button class="btn btn-sm" data-dismiss="modal" type="button">取消</button>
                        <button class="btn btn-sm btn-primary" type="submit">保存</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    // 创建分类时清空表单数据
    function clearForm()
    {
        var form = $("#flow-validation-form");
        form.find("h4").html("添加流程");
        form.find("select[name='pid']").val(0);
        form.find("input[name='id']").val(0);
        form.find("input[name='name']").val('');
        form.find("input[name='order']").val('99');
        form.find("textarea[name='brief']").val('');
    }

    // 添加数据到表单中
    function editForm(id)
    {
        var info = $.parseJSON($("tr[item-id=" + id + "]").attr("item-info"));
        var form = $("#flow-validation-form");
        form.find("h4").html("修改流程");
        form.find("select[name='cat_id']").val(info.cat_id);
        form.find("input[name='name']").val(info.name);
        form.find("input[name='order']").val(info.order);
        form.find("input[name='id']").val(info.id);
        form.find("textarea[name='brief']").val(info.brief);
    }

    // 分类选择切换
    function onCatSelectionChange(catid)
    {
        window.location.href = '/trace.flow?catid=' + catid;
    }

    jQuery(function($) {
        $(".select3").select2({allowClear:true}).on('change', function(){
            onCatSelectionChange($(this).val());
        });

        // 分类表单校验
        $('#flow-validation-form').validate({
            errorElement: 'div',
            errorClass  : 'help-block',
            focusInvalid: true,
            rules       : {
                name:  { required: true },
                order: { required: true }
            },
            messages    : {
                name:  { required: "流程名称不能为空" },
                order: { required: "流程排序不能为空" }
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

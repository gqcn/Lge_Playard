<style type="text/css">
.table thead > tr > th, 
.table tbody > tr > th, 
.table tfoot > tr > th, 
.table thead > tr > td, 
.table tbody > tr > td, 
.table tfoot > tr > td  {vertical-align: middle;}
</style>


<div class="row">
<div class="col-xs-12">


<form class="form-horizontal" action="?" method="get">

<div class="clearfix"></div>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:70px;">排序</th>
            <th style="width:80px;">模型ID</th>
            <th style="width:180px;">模型Key</th>
            <th style="width:180px;">模型名称</th>
            <th>模型描述</th>
            <th style="width:140px;" class="center">创建时间</th>
            <th style="width:140px;" class="center">修改时间</th>
            <th style="width:100px;"  class="center">操作</th>
        </tr>
    </thead>

    <tbody>
    {if $list}
        {foreach from=$list index=$index key=$key item=$item}
        <tr id="{$item['model_id']}">
            <td>{$item['order']}</td>
            <td>{$item['model_id']}</td>
            <td>{$item['model_key']}</td>
            <td>{$item['model_name']}</td>
            <td>{$item['brief']}</td>
            <td>{$_Time->format($item['create_time'])}</td>
            <td>{$_Time->format($item['update_time'])}</td>
            <td class="center">
                <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
                    <a href="?app={$_GET['app']}&act=showEdit&id={$item['model_id']}" class="green" title="修改模型" data-rel="tooltip">
                        <i class="icon-pencil bigger-130"></i>
                    </a>
                    
                    <a href="?app={$_GET['app']}&act=showContentEdit&model_id={$item['model_id']}" class="green" title="添加内容" data-rel="tooltip">
                        <i class="icon-plus bigger-130"></i>
                    </a>

                    <a href="javascript:deleteItem({$item['model_id']});" class="red ButtonDelete" title="删除模型" data-rel="tooltip">
                        <i class="icon-trash bigger-130"></i>
                    </a>
                </div>
            </td>
        </tr>
        {/foreach}
    {/if}
    </tbody>
</table>
</form>

</div>
</div>



<script type="text/javascript">
// 删除数据项
function deleteItem(id)
{
    var message = "<div class='bigger-110'>确认删除该模型？</div>";
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
                    window.location.href='?app=model&act=delete&id=' + id
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
});
</script>

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
<input type="hidden" name="app" value="{$_GET['app']}">
<input type="hidden" name="act" value="{$_GET['act']}">

<div class="row" style="margin-bottom:10px;">
    <div class="input-group col-xs-1" title="分页大小" data-rel="tooltip" >
    <select class="select2" name="limit">
        <option value="10" {if $_GET['limit'] == 10}selected{/if}>10</option>
        <option value="20" {if $_GET['limit'] == 20}selected{/if}>20</option>
        <option value="30" {if $_GET['limit'] == 30}selected{/if}>30</option>
        <option value="50" {if $_GET['limit'] == 50}selected{/if}>50</option>
        <option value="80" {if $_GET['limit'] == 80}selected{/if}>80</option>
        <option value="100" {if $_GET['limit'] == 100}selected{/if}>100</option>
    </select>
    </div>
    
    <div class="input-group col-xs-1" title="连接分类" data-rel="tooltip" >
    <select class="select2" name="cat_id">
        <option value="0">所有分类</option>
        {if $catArray}
        {foreach from=$catArray index=$index key=$key item=$item}
        <option value="{$item['cat_id']}" {if $_GET['cat_id'] == $item['cat_id']}selected{/if}>{$item['cat_name']}</option>
        {/foreach}
        {/if}
    </select>
    </div>

    <div class="input-group col-xs-3" title="标题搜索" data-rel="tooltip" >
    <input type="text" name="key" placeholder="连接标题关键字查询" class="form-control search-query" value="{$_String->escape($_GET['key'])}">
    <span class="input-group-btn">
        <button class="btn btn-info btn-sm" type="submit">
            <i class="icon-search icon-on-right bigger-110"></i>
        </button>
    </span>
    </div>
</div>

<div class="clearfix"></div>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:70px;">排序</th>
            <th style="width:80px;">连接ID</th>
            <th style="width:100px;">连接缩略图</th>
            <th>连接标题</th>
            <th style="width:180px;">连接分类</th>
            <th>连接地址</th>
            <th style="width:140px;" class="center">创建时间</th>
            <th style="width:80px;"  class="center">操作</th>
        </tr>
    </thead>

    <tbody>
    {if $list}
        {foreach from=$list index=$index key=$key item=$item}
        <tr id="{$item['link_id']}">
            <td>{$item['order']}</td>
            <td>{$item['link_id']}</td>
            <td>{if $item['thumb']}<a href="{$item['thumb']}" target="_blank">查看</a>{else}无{/if}</td>
            <td>
            {if $_GET['key']}
                {$_String->highlight($item['title'], $_GET['key'])}</a>
            {else}
                {$item['title']}
            {/if}
            </td>
            <td>
            {if $item['cat_name']}
            <a href="?app={$_GET['app']}&act={$_GET['act']}&cat_id={$item['cat_id']}">{$item['cat_name']}</a>
            {else}
            -
            {/if}
            </td>
            <td>{$item['url']}</td>
            <td>{$_Time->format($item['create_time'])}</td>
            <td class="center">
                <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
                    <a href="?app=link&act=showEdit&id={$item['link_id']}" class="green" title="修改" data-rel="tooltip">
                        <i class="icon-pencil bigger-130"></i>
                    </a>

                    <a href="javascript:deleteItem({$item['link_id']});" class="red ButtonDelete" title="删除" data-rel="tooltip">
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
<div style="text-align:center;">         
<ul class="pagination">{$page}</ul>
</div>



</div>
</div>



<script type="text/javascript">
// 删除数据项
function deleteItem(id)
{
    var message = "<div class='bigger-110'>确认删除该连接？</div>";
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
                    window.location.href='?app=link&act=delete&id=' + id
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

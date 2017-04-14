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
<input type="hidden" name="app" value="{$_Get->data['app']}">
<input type="hidden" name="act" value="{$_Get->data['act']}">

<div class="row" style="margin-bottom:10px;">
    <div class="input-group col-xs-1" title="分页大小" data-rel="tooltip" >
    <select class="select2" name="limit">
        <option value="10" {if $_Get->data['limit'] == 10}selected{/if}>10</option>
        <option value="20" {if $_Get->data['limit'] == 20}selected{/if}>20</option>
        <option value="30" {if $_Get->data['limit'] == 30}selected{/if}>30</option>
        <option value="50" {if $_Get->data['limit'] == 50}selected{/if}>50</option>
        <option value="80" {if $_Get->data['limit'] == 80}selected{/if}>80</option>
        <option value="100" {if $_Get->data['limit'] == 100}selected{/if}>100</option>
    </select>
    </div>
    
    <div class="input-group col-xs-1" title="文章分类" data-rel="tooltip" >
    <select class="select2" name="cat_id">
        <option value="0">所有分类</option>
        {if $catArray}
        {foreach from=$catArray index=$index key=$key item=$item}
        <option value="{$item['cat_id']}" {if $_Get->data['cat_id'] == $item['cat_id']}selected{/if}>{$item['cat_name']}</option>
        {/foreach}
        {/if}
    </select>
    </div>

    <div class="input-group col-xs-3" title="标题搜索" data-rel="tooltip" >
    <input type="text" name="key" placeholder="文章标题关键字查询" class="form-control search-query" value="{$_String->escape($_Get->data['key'])}">
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
            <th style="width:80px;">文章ID</th>
            <th>文章标题</th>
            <th style="width:180px;">文章分类</th>
            <th style="width:150px;">文章作者</th>
            <th style="width:140px;" class="center">创建时间</th>
            <th style="width:140px;" class="center">修改时间</th>
            <th style="width:140px;" class="center">发布时间</th>
            <th style="width:80px;"  class="center">操作</th>
        </tr>
    </thead>

    <tbody>
    {if $list}
        {foreach from=$list index=$index key=$key item=$item}
        <tr id="{$item['article_id']}">
            <td>{$item['order']}</td>
            <td>{$item['article_id']}</td>
            <td>
            {if $_Get->data['key']}
                {$_String->highlight($item['title'], $_Get->data['key'])}</a>
            {else}
                {$item['title']}
            {/if}
            </td>
            <td>
            {if $item['cat_name']}
            <a href="?app={$_Get->data['app']}&act={$_Get->data['act']}&cat_id={$item['cat_id']}">{$item['cat_name']}</a>
            {else}
            -
            {/if}
            </td>
            <td>{$item['author']}</td>
            <td>{$_Time->format($item['create_time'])}</td>
            <td>{$_Time->format($item['update_time'])}</td>
            <td>{$_Time->format($item['release_time'])}</td>
            <td class="center">
                <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
                    <a href="?app=article&act=showEdit&id={$item['article_id']}" class="green" title="修改" data-rel="tooltip">
                        <i class="icon-pencil bigger-130"></i>
                    </a>

                    <a href="javascript:deleteItem({$item['article_id']});" class="red ButtonDelete" title="删除" data-rel="tooltip">
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
    var message = "<div class='bigger-110'>确认删除该文章？</div>";
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
                    window.location.href='?app=article&act=delete&id=' + id
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

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
    
    <div class="input-group col-xs-1" title="图片分类" data-rel="tooltip" >
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
    <input type="text" name="key" placeholder="图片标题关键字查询" class="form-control search-query" value="{$_String->escape($_GET['key'])}">
    <span class="input-group-btn">
        <button class="btn btn-info btn-sm" type="submit">
            <i class="icon-search icon-on-right bigger-110"></i>
        </button>
    </span>
    </div>
</div>

<div class="clearfix"></div>

<!-- PAGE CONTENT BEGINS -->

<div class="row-fluid">
    <ul class="ace-thumbnails">
    {if $list}
        {foreach from=$list index=$index key=$key item=$item}
        <li>
            <a target="_blank" href="{$item['thumb']}" class="cboxElement">
                <img src="{$item['thumb']}?150_150" alt="{$item['title']}" width="150" height="150">
                <div class="text">
                    <div class="inner">{$item['title']}</div>
                </div>
            </a>

            <div class="tools tools-bottom">
                <a href="?app=picture&act=showEdit&id={$item['picture_id']}" class="green" title="修改" data-rel="tooltip">
                    <i class="icon-pencil bigger-130"></i>
                </a>

                <a href="javascript:deleteItem({$item['picture_id']});" class="red ButtonDelete" title="删除" data-rel="tooltip">
                    <i class="icon-trash bigger-130"></i>
                </a>
            </div>
        </li>
        {/foreach}
    {/if}
    </ul>
</div>

<div class="clearfix"></div>
<div style="text-align:center;">         
<ul class="pagination">{$page}</ul>
</div>





</form>



</div>
</div>



<script type="text/javascript">
// 删除数据项
function deleteItem(id)
{
    var message = "<div class='bigger-110'>确认删除该图片？</div>";
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
                    window.location.href='?app=picture&act=delete&id=' + id
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

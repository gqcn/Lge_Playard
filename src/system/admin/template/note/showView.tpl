<div class="row">
<div class="col-xs-12">
<form class="form-horizontal" id="validation-form" action="?app=note&act=edit" method="post" enctype="multipart/form-data">
<input type="hidden" name="note_id" value="{$data['note_id']}"/>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2 no-padding-right">笔记分类:</label>
        <div class="col-xs-12 col-sm-9">
        <div style="margin:6px 0 0 0px;">
        {if $catArray}
            {foreach from=$catArray index=$index key=$key item=$item}
                {if $data['cat_id'] == $item['cat_id']}{$item['cat_name']}{/if}
            {/foreach}
        {else}
        (无分类)
        {/if}
        </div>
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2 no-padding-right">笔记标题:</label>
        <div class="col-xs-12 col-sm-9">
            <div style="margin:6px 0 0 0px;">
                {$data['title']}
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2 no-padding-right">笔记内容:</label>
        <div class="col-xs-12 col-sm-9">
        <div style="margin:6px 0 0 0px;">
            {$data['content']}
        </div>
        </div>
    </div>
    

    
     <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2 no-padding-right"></label>
        <div class="col-xs-12 col-sm-9">
        <div class="clearfix">
            <button class="btn btn-success" type="button" onclick="history.go(-1)">
                <i class="icon-arrow-left icon-on-left bigger-110"></i> 返回
            </button>
            
            <button class="btn btn-info" type="button" onclick="window.location.href='?app={$_GET['app']}&act=showEdit&id={$_GET['id']}'">
                修改 <i class="icon-arrow-right icon-on-right bigger-110"></i>
            </button>
            </div>
        </div>
    </div>

</form>
</div>
</div>

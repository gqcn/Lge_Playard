<div class="row">
<div class="col-xs-12">
<form class="form-horizontal" id="validation-form" action="?app=note&act=edit" method="post" enctype="multipart/form-data">
<input type="hidden" name="note_id" value="{$data['note_id']}"/>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2 no-padding-right">笔记分类:</label>
        <div class="col-xs-12 col-sm-9">
        {if $catArray}
        <select class="select2" name="cat_id">
            {foreach from=$catArray index=$index key=$key item=$item}
            <option value="{$item['cat_id']}" {if $data['cat_id'] == $item['cat_id']}selected{/if}>{$item['cat_name']}</option>
            {/foreach}
        </select>
        {else}
        <div style="margin:5px 0 0 0px;">当前没有笔记分类，您可以点这 <a href="?app=note&act=category" target="_blank">创建分类</a></div>
        {/if}
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2 no-padding-right">笔记排序:</label>
        <div class="col-xs-12 col-sm-9">
            <div class="clearfix">
                <input value="{$data['order']}" type="text" name="order" class="col-xs-12 col-sm-12" style="width:305px;"/>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2 no-padding-right required">笔记标题:</label>
        <div class="col-xs-12 col-sm-9">
            <div class="clearfix">
                <input value="{$data['title']}" type="text" name="title" class="col-xs-12 col-sm-12" />
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2 no-padding-right">笔记内容:</label>
        <div class="col-xs-12 col-sm-9">
            <div style="margin:0 0 5px 0;">
            <button class="btn btn-sm btn-info" onclick="showMediaSelection()" type="button"> <i class="icon-magnet"></i> 添加媒体 </button>
            格式支持: 图片(png、jpg、jpeg、gif), 音频(mp3、aac、wav、ogg、ogv、m4a), 视频(flv、mp4、mov、f4v、3gp、3g2)
            </div>
            <script name="content" id="editor">{$data['content']}</script>
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

{include _subinc/elfinder}
{include _subinc/ueditor}
    
    
<script type="text/javascript">

//显示添加媒体文件对话框
function showMediaSelection()
{
    showFileManager("添加/选择多媒体文件", function(files){
    	addMediaToUEditor(files);
    });
}

jQuery(function($) {

	$(".select2").css('width','305px').select2({allowClear:true})
    .on('change', function(){
        $(this).closest('form').validate().element($(this));
    }); 
    

    UE.getEditor('editor');
    
    $('#validation-form').validate({
        errorElement: 'div',
        errorClass: 'help-block',
        focusInvalid: true,
        rules: {
            title: {
                required: true
            }
        },
        messages: {
            title: {
                required: "笔记标题不能为空"
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























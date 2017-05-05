<div class="row">
<div class="col-xs-12">
<form class="form-horizontal" id="validation-form" action="?" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="{$data['id']}"/>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2 no-padding-right">文章分类:</label>
        <div class="col-xs-12 col-sm-9">
        {if $catArray}
            <select class="select2" name="cat_id">
                {foreach from=$catArray index=$index key=$key item=$item}
                <option value="{$item['cat_id']}" {if $data['cat_id'] == $item['cat_id']}selected{/if}>{$item['cat_name']}</option>
                {/foreach}
            </select>
        {else}
            <div style="margin:5px 0 0 0px;">当前没有文章分类，您可以点这 <a href="/article/category" target="_blank">创建分类</a></div>
        {/if}
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2 no-padding-right required">文章作者:</label>
        <div class="col-xs-12 col-sm-9">
            <div class="clearfix">
                <input value="{$data['author']}" type="text" name="author" class="col-xs-12 col-sm-12" style="width:305px;"/>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2 no-padding-right">文章排序:</label>
        <div class="col-xs-12 col-sm-9">
            <div class="clearfix">
                <input value="{$data['order']}" type="text" name="order" class="col-xs-12 col-sm-12" style="width:305px;"/>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2 no-padding-right">发布时间:</label>
        <div class="col-xs-12 col-sm-9">
            <div class="clearfix">
                <div class="input-group" style="width:150px;float:left;">
                    <input value="{$data['release_date']}"  name="release_date" class="form-control date-picker" id="id-date-picker" type="text" data-date-format="yyyy-mm-dd" />
                    <span class="input-group-addon">
                        <i class="fa fa-calendar bigger-110"></i>
                    </span>
                </div>
                
                <div class="input-group bootstrap-timepicker" style="width:150px;float:left;margin:0 0 0 5px;">
                    <input value="{$data['release_time']}" name="release_time" id="timepicker" type="text" class="form-control"/>
                    <span class="input-group-addon">
                        <i class="fa fa-clock-o bigger-110"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2 no-padding-right required">文章标题:</label>
        <div class="col-xs-12 col-sm-9">
            <div class="clearfix">
                <input value="{$data['title']}" type="text" name="title" class="col-xs-12 col-sm-12" />
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2 no-padding-right">文章来源:</label>
        <div class="col-xs-12 col-sm-9">
            <div class="clearfix">
                <input value="{$data['referer']}" type="text" name="referer" class="col-xs-12 col-sm-12" placeholder="http://"/>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2 no-padding-right">文章跳转:</label>
        <div class="col-xs-12 col-sm-9">
            <div class="clearfix">
                <input value="{$data['referto']}" type="text" name="referto" class="col-xs-12 col-sm-12" placeholder="如果设置，当查看该文章时，页面将自动跳转到该URL"/>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2 no-padding-right" for="url">缩略图片: {if $data['thumb']}(<a href="{$data['thumb']}" target="_blank">查看</a>){/if}</label>
        <div class="col-xs-12 col-sm-9">
        <input value="{$data['thumb']}" name="thumb" type="text" class="col-xs-12 col-sm-12" placeholder="点击选择或上传文章的缩略图" onclick="showThumbSelection()"/>
        </div>
    </div>


    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2 no-padding-right">文章摘要:</label>
        <div class="col-xs-12 col-sm-9">
            <div class="clearfix">
                <textarea name="brief" style="height:150px;padding:5px 4px;" class="col-xs-12 col-sm-12" >{$data['brief']}</textarea>
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2 no-padding-right">文章内容:</label>
        <div class="col-xs-12 col-sm-9">
            <div style="margin:0 0 5px 0;">
            <button class="btn btn-sm btn-info" onclick="showMediaSelection()" type="button"> <i class="icon-magnet"></i> 添加媒体 </button>
            格式支持: 图片(png、jpg、jpeg、gif), 音频(mp3、aac、wav、ogg、ogv、m4a), 视频(flv、mp4、mov、f4v、3gp、3g2)
            </div>
            <script name="content" id="editor">{$data['content']}</script>
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2 no-padding-right">文章标签:</label>
        <div class="col-xs-12 col-sm-9">
            <div class="clearfix">
                <input  value="{$data['tags']}" placeholder="输入标签后按回车键添加" type="text" name="tags" id="form-field-tags" class="col-xs-12 col-sm-12" style="width:100%;"/>
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

{include _subinc/elfinder}
{include _subinc/ueditor}

<script type="text/javascript">
// 显示缩略图上传/选择文件对话框
function showThumbSelection()
{
	showFileManager("缩略图选择", function(files){
		$("input[name=thumb]").val(files);
	}, ['image']);
}

//显示添加媒体文件对话框
function showMediaSelection()
{
    showFileManager("添加/选择多媒体文件", function(files){
    	addMediaToUEditor(files);
    });
}

jQuery(function($) {
    $('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
        $(this).prev().focus();
    });
    $('#timepicker').timepicker({
        minuteStep: 1,
        showSeconds: true,
        showMeridian: false
    }).next().on(ace.click_event, function(){
        $(this).prev().focus();
    });

	$(".select2").css('width','305px').select2({allowClear:true})
    .on('change', function(){
        $(this).closest('form').validate().element($(this));
    }); 

    UE.getEditor('editor');
    
    $('#validation-form').validate({
        errorElement: 'div',
        errorClass  : 'help-block',
        focusInvalid: true,
        rules: {
            title:   { required: true },
            author:  { required: true },
            referer: { url: true },
            referto: { url: true }
        },
        messages: {
            title:   { required: "文章标题不能为空" },
            author:  { required: "文章作者不能为空" },
            referer: { url: "您输入的URL格式不正确" },
            referto: { url: "您输入的URL格式不正确" }
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























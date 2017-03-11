<div class="row">
    <div class="col-xs-12">
        <form class="form-horizontal" id="validation-form" action="/trace.product/flow" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-2 no-padding-right required">产品批次:</label>
                        <div class="col-xs-12 col-sm-10">
                            <div class="clearfix">
                                <input style="width:200px;" readonly name="batch_no" class="input-large" type="text" placeholder="产品批次编号不能重复" value="{$data['batch_no']}" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-2 no-padding-right required">产品名称:</label>
                        <div class="col-xs-12 col-sm-10">
                            <div class="clearfix">
                                <input readonly class="col-xs-12 col-sm-10" type="text" placeholder="请输入产品名称" value="{$data['name']}" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-2 no-padding-right">产品详情:</label>
                        <div class="col-xs-12 col-sm-10">
                            <div class="tabbable col-sm-10 no-padding">
                                <ul class="nav nav-tabs">
                                    {foreach from=$data['content_flow'] index=$index key=$key item=$item}
                                        <li {if $index == 0}class="active"{/if}>
                                            <a data-toggle="tab" href="#tab_{$key}">{$item['name']}</a>
                                        </li>
                                    {/foreach}
                                </ul>

                                <div class="tab-content" style="min-height: 300px;">
                                    {foreach from=$data['content_flow'] index=$index key=$key item=$item}
                                        <div id="tab_{$key}" class="tab-pane fade {if $index == 0}active in{/if}">
                                            <div style="margin:0 0 5px 0;">
                                                <button class="btn btn-sm btn-info" onclick="showMediaSelection('editor_{$key}')" type="button">
                                                    <i class="ace-icon fa fa-inbox"></i> 添加媒体 </button>
                                                格式支持：图片(png、jpg、jpeg、gif), 音频(mp3、wav、ogg等), 视频(flv、mp4、mov、f4v等)
                                            </div>
                                            <input name="content_flow[{$key}][name]" type="hidden" value="{$item['name']}"/>
                                            <textarea name="content_flow[{$key}][content]" id="editor_{$key}">{$item['content']}</textarea>
                                        </div>
                                    {/foreach}
                                </div>
                            </div>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-2 no-padding-right"></label>
                <div class="col-xs-12 col-sm-10">
                    <div class="clearfix">
                        <button class="btn btn-info" type="submit">
                            <i class="ace-icon fa fa-check bigger-110"></i>
                            保存&nbsp;&nbsp;&nbsp;
                        </button>

                        <button class="btn" type="button" onclick="history.go(-1)">
                            <i class="ace-icon fa fa-reply bigger-110"></i>
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
jQuery(function($) {
    {foreach from=$data['content_flow'] index=$index key=$key item=$item}
        UE.getEditor('editor_{$key}');
    {/foreach}

    $('#validation-form').validate({
        errorElement: 'div',
        errorClass: 'help-block',
        focusInvalid: true,
        rules: {
            order:   {required: true},
            number:  {required: true},
            name:    {required: true}
        },
        messages: {
            order:   {required: "产品排序不能为空"},
            number:  {required: "产品数量不能为空"},
            name:    {required: "产品名称不能为空"}
        },
        submitHandler: function(form) {
            $("input[name='keys']").val(getCheckedKeys());
            form.submit();
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























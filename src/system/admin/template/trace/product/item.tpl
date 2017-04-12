<div class="row">
    <div class="col-xs-12">
        <form class="form-horizontal" id="validation-form" action="/trace.product/item" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-2 no-padding-right required">产品分类:</label>
                        <div class="col-xs-12 col-sm-10">
                            <div class="clearfix">
                                <select class="select2" name="cat_id" style="width:200px;">
                                    {foreach from=$catList index=$index key=$key item=$item}
                                        <option value="{$item['id']}" {if $item['id'] == $data['cat_id']}selected{/if}>{$item['name']}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-2 no-padding-right required">产品排序:</label>
                        <div class="col-xs-12 col-sm-10">
                            <div class="clearfix">
                                <input style="width:200px;" name="order" class="input-large" type="text" placeholder="序号越小，排序越靠前" value="{$data['order']}" />
                                <span style="padding:7px 0 0 0px;">&nbsp;序号越小，排序越靠前</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-2 no-padding-right required">产品批次:</label>
                        <div class="col-xs-12 col-sm-10">
                            <div class="clearfix">
                                <input style="width:200px;" readonly name="batch_no" class="input-large" type="text" placeholder="产品批次编号不能重复" value="{$data['batch_no']}" />
                                <span style="padding:7px 0 0 0px;">&nbsp;同一批次的产品信息相同，由系统生成</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-2 no-padding-right required">产品数量:</label>
                        <div class="col-xs-12 col-sm-10">
                            <div class="clearfix">
                                <input style="width:200px;" name="number" class="input-large" type="text" placeholder="系统以此生成产品编码" value="{$data['number']}" />
                                <span style="padding:7px 0 0 0px;">&nbsp;该批次下的产品数量，系统根据该数量生成产品编码</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-2 no-padding-right required">产品名称:</label>
                        <div class="col-xs-12 col-sm-10">
                            <div class="clearfix">
                                <input name="name"  class="col-xs-12 col-sm-10" type="text" placeholder="请输入产品名称" value="{$data['name']}" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-2 no-padding-right">产品简述:</label>
                        <div class="col-xs-12 col-sm-10">
                            <div class="clearfix">
                            <textarea name="brief" class="col-xs-12 col-sm-10" placeholder="关于该产品的简要描述"
                                      style="height:100px;padding:5px 4px;" >{$data['brief']}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-2 no-padding-right">产品详情:</label>
                        <div class="col-xs-12 col-sm-10">
                            <div style="margin:0 0 5px 0;">
                                <button class="btn btn-sm btn-info" onclick="showMediaSelection('editor')"flow-validation-form type="button">
                                    <i class="ace-icon fa fa-inbox"></i> 添加媒体
                                </button>
                                格式支持：图片(png、jpg、jpeg、gif), 音频(mp3、wav、ogg等), 视频(flv、mp4、mov、f4v等)
                            </div>
                            <textarea name="content" id="editor">{$data['content']}</textarea>
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
    UE.getEditor('editor');

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























<div class="row">
    <div class="col-xs-12">
        <form class="form-horizontal" id="validation-form" action="/setting/set" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-2 no-padding-right required">系统地址:</label>
                        <div class="col-xs-12 col-sm-10">
                            <div class="clearfix">
                                <input name="k" type="hidden" value="trace.site_url" />
                                <input name="v" class="col-xs-12 col-sm-10" type="text" placeholder="用以生成二维码链接的URL前缀，请以http开始，例如：http://xxx.xxx.com/" value="{$setting['trace.site_url']}" />
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
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>


















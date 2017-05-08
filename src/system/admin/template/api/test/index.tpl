<style type="text/css">
    html { overflow-x: hidden; overflow-y: auto; }
    #api-test-list {
        padding:0 5px 0 0;
    }
    #api-test-content {
        min-height:300px;
        padding:0 0 0 5px;
        border-left:1px solid #eee;
    }
</style>


<div class="row">
    <div class="col-xs-12" style="padding:0 0 10px 0;">
        <div style="float:left;margin:0 10px 0 0;">
            <a href="javascript:onClickApiTest({$item['0']});" class="btn btn-sm btn-primary" title="添加接口测试" data-rel="tooltip">
                <i class="ace-icon fa fa-plus bigger-110"></i>添加测试
            </a>
        </div>

        <div style="float:left;margin:0 10px 0 0;" title="选择可切换应用" data-rel="tooltip">
            <select class="select3" name="appid" style="width:180px;">
                {foreach from=$apps index=$index key=$key item=$item}
                    <option value="{$item['id']}" {if $item['id'] == $_GET['appid']}selected{/if}>{$item['name']}</option>
                {/foreach}
            </select>
        </div>

        <div class="input-group col-xs-3 no-padding-left" title="接口搜索" data-rel="tooltip" >
            <input type="text" name="key" placeholder="请输入接口测试名称关键字进行搜索" class="form-control search-query" value="{$_String->escape($_GET['key'])}">
            <span class="input-group-btn">
                <button class="btn btn-info btn-sm" type="button" onclick="searchApi()">
                    <i class="ace-icon fa fa-search fa-on-right bigger-110"></i>
                </button>
            </span>
        </div>

    </div>

    <div id="api-test-list" class="col-xs-12 col-lg-3"></div>
    <div id="api-test-content" class="col-xs-12 col-lg-9"></div>
</div>


<script type="text/javascript">

    // 设置当前操作的名称，该名称将会显示在breadcrumb末尾
    function setCurrentActionName(name)
    {
        $('.breadcrumb .active').html(name);
    }

    // 应用选择切换
    function onAppSelectionChange(appid)
    {
        window.location.href = '/api.api?appid=' + appid
    }

    // 重新加载接口测试列表
    function reloadApiTestList()
    {
        setCurrentActionName('接口测试');
        $('#api-test-list').load('/api.test/list?appid={$_GET['appid']}&__content=1');
    }

    // 展示测试接口
    function showApiTest(id)
    {
        currentTestid = id;
        $('#api-test-content').load('/api.test/item?appid={$_GET['appid']}&id='+id+'&__content=1');
    }

    // 展示测试接口
    function showApiTestByApiId(id)
    {
        currentTestid = id;
        $('#api-test-content').load('/api.test/item?appid={$_GET['appid']}&apiid='+id+'&__content=1');
    }

    // 根据关键字搜索API
    function searchApi()
    {
        var key = $("input[name=key]").val();
        $('#api-test-list').load('/api.test/list?appid={$_GET['appid']}&key=' + encodeURIComponent(key) + '&__content=1');
    }

    var currentAppid  = {$_GET['appid']};
    var currentTestid = 0;

    jQuery(function($) {
        $(".select3").select2({allowClear:true}).on('change', function(){
            onAppSelectionChange($(this).val());
        });
        reloadApiTestList();
        showApiTest(0);
    });

</script>

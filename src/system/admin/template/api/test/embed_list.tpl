<style type="text/css">
    #api-test-list-table tr.sortable-placeholder {
        height:40px;
        border-style: dashed;
    }
    .api-test-list-td {
        cursor:pointer;
    }
    .api-test-list-td.active {

    }
</style>
<script src="{$sysurl}/assets/js/common.js"></script>

{if $list}
    <form class="form-horizontal" id="apt-test-list-sort-form" action="/api.test/ajaxSort" method="post">
        <table id="api-test-list-table" class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th style="min-width:150px;" class="center">接口测试名称</th>
                <th class="center">接口地址</th>
                <th style="width:50px;" class="center">操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$list index=$index key=$key item=$item}
                <tr item-id="{$item['id']}">
                    <td class="api-test-list-td" onclick="onClickApiTest({$item['id']})">
                        <input type="hidden" name="ids[]"  value="{$item['id']}">
                        {$item['name']}
                    </td>
                    <td class="api-test-list-td" onclick="onClickApiTest({$item['id']})">
                        {$item['address']}
                    </td>
                    <td class="center" >
                        {if $item['id']}
                            <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons" style="margin-top:10px;">
                                <a href="javascript:ajaxDeleteItem('/api.test/ajaxDelete?id={$item['id']}');" class="red ButtonDelete" title="删除" data-rel="tooltip">
                                    <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                </a>
                            </div>
                        {else}
                            -
                        {/if}
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </form>
{/if}



<script type="text/javascript">
    // 点击测试
    function onClickApiTest(id)
    {
        $('.api-test-list-td').removeClass('active');
        $('#api-test-list-table tr[item-id='+ id +'] .api-test-list-td').addClass('active');
        showApiTest(id);
    }

    // 异步删除操作
    function ajaxDeleteItem(url)
    {
        var message = "<div class='bigger-110'>删除之后数据将无法恢复，确定要删除该数据？</div>";
        bootbox.dialog({
            message: message,
            buttons: {
                "button" : {
                    "label" : "取消",
                    "className" : "btn-sm"
                },
                "danger" : {
                    "label" : "删除",
                    "className" : "btn-sm btn-danger",
                    "callback": function() {
                        $.ajax({
                            url     : url,
                            dataType: 'json',
                            success : function(result){
                                if (result.result) {
                                    $.gritter.add({
                                        title: '成功提示',
                                        text : result.message,
                                        class_name: 'gritter-success gritter-right'
                                    });
                                    reloadApiTestList();
                                } else {
                                    $.gritter.add({
                                        title: '错误提示',
                                        text : result.message,
                                        class_name: 'gritter-error gritter-right'
                                    });
                                }
                                $('.modal-backdrop').hide();
                            }
                        });
                    }
                }
            }
        });
    }

    jQuery(function($) {
        // 排序
        $('#api-test-list-table tbody').sortable({
            placeholder: "sortable-placeholder"
        }).on('sortupdate', function(){
            $('#apt-test-list-sort-form').ajaxSubmit({
                dataType: 'json',
                success : function(result){
                    if (result.result) {
                        $.gritter.add({
                            title: '成功提示',
                            text : '列表重新排完成',
                            class_name: 'gritter-success gritter-right'
                        });
                        reloadApiTestList();
                    }
                }
            });
        });
    });

</script>

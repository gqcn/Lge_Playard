<style type="text/css">
    html { overflow-x: hidden; overflow-y: auto; }
    #api-category-content {
        padding:0 5px 0 0;
    }
    #api-api-content {
        min-height:300px;
        padding:0 0 0 5px;
        border-left:1px solid #eee;
    }
    #api-category-table tr.sortable-placeholder {
        height:40px;
        border-style: dashed;
    }
    .category-td.active {
        font-weight:bold;
        font-size:14px;
    }
</style>


<div class="row">
    <div class="col-xs-12" style="padding:0 0 10px 0;">
        <form class="form-horizontal" action="?" method="get">
            <div style="float:left;margin:0 10px 0 0;">
                <a href="/trace.product/item" class="btn btn-sm btn-success" title="添加产品/批次" data-rel="tooltip">
                    <i class="ace-icon fa fa-plus bigger-110"></i>添加产品/批次
                </a>
            </div>

            <div class="input-group col-xs-1 no-padding-left" title="分页大小" data-rel="tooltip" style="width:70px;">
                <select class="select2" name="limit" style="width:70px;">
                    {foreach from=$limits index=$index key=$k item=$v}
                        <option value="{$v}" {if $_Get->data['limit'] === $k}selected{/if}>{$v}</option>
                    {/foreach}
                </select>
            </div>

            <div style="float:left;margin:0 10px 0 0;" title="请选择需要展示的分类" data-rel="tooltip">
                <select class="select2" name="catid" style="width:160px;">
                    <option value="0" {if 0 == $_Get->data['catid']}selected{/if}>展示所有分类的产品</option>
                    {foreach from=$catList index=$index key=$key item=$item}
                        <option value="{$item['id']}" {if $item['id'] == $_Get->data['catid']}selected{/if}>{$item['name']}</option>
                    {/foreach}
                </select>
            </div>

            <div class="input-group col-xs-3 no-padding-left" title="产品搜索" data-rel="tooltip" >
                <input type="text" name="key" placeholder="请输入产品编码/批次编号进行查询" class="form-control search-query" value="{$_String->escape($_Get->data['key'])}">
                <span class="input-group-btn">
                    <button class="btn btn-info btn-sm" type="submit">
                        <i class="ace-icon fa fa-search fa-on-right bigger-110"></i>
                    </button>
                </span>
            </div>
        </form>
    </div>
    {if $list}
        <table id="api-category-table" class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th style="width:80px;" class="center">批次编号</th>
                <th>产品数量</th>
                <th>产品名称</th>
                <th>所属分类</th>
                <th>产品说明</th>
                <th style="width:120px;" class="center">操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$list index=$index key=$key item=$item}
                <tr>
                    <td {if $_Get->data['key']}class="red"{/if}>{$item['batch_no']}</td>
                    <td>{$item['number']}</td>
                    <td>{$item['name']}</td>
                    <td>{$item['cat_name']}</td>
                    <td>{$item['brief']}</td>
                    <td class="center" >
                        <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons" style="margin-top:10px;">
                            <a href="/trace.product/flow?batch_no={$item['batch_no']}" class="blue" title="溯源管理" data-rel="tooltip">
                                <i class="ace-icon fa fa-truck bigger-130"></i>
                            </a>
                            &nbsp;
                            <a href="/trace.product/item?batch_no={$item['batch_no']}" class="green" title="修改产品" data-rel="tooltip">
                                <i class="ace-icon fa fa-pencil bigger-130"></i>
                            </a>
                            &nbsp;
                            <a href="javascript:deleteItem('/trace.product/delete?batch_no={$item['batch_no']}');" class="red ButtonDelete" title="删除产品" data-rel="tooltip">
                                <i class="ace-icon fa fa-trash-o bigger-130"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    {else}
        暂无产品信息，请更换查询条件或者点击“添加产品”添加产品。
    {/if}

</div>


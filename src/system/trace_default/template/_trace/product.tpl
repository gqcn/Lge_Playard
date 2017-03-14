<section id="section-default" data-role="section" class="active">
    {* 产品详情 *}
    <header>
        <div class="titlebar">
            <h1 class="text-center">{$data['name']}</h1>
        </div>
    </header>

    <article data-role="article" id="product-detail" class="active" style="top:44px;bottom:50px;">
        <div class="scroller">
            <div id="product-detail-content" style="padding:5px;">
                <div>产品名称：{$data['name']}</div>
                <div>产品编号：{$productNo}</div>
                <div>产品介绍：{$data['content']}</div>
            </div>
        </div>
    </article>

    {* 溯源详情 *}
    <article data-role="article" id="trace-detail" style="top:44px;bottom:50px;">
        <div class="scroller">
            <ul class="list">
                {foreach from=$data['content_flow'] index=$index key=$key item=$item}
                    <li>
                        <div class="justify-content">
                            <div style="padding:0 0 5px 0;font-size:18px;color:#C0392B;">
                                {$index + 1}、{$item['name']}：
                            </div>
                            {if $item['date']}
                                <p>操作日期：{$item['date']} {if $item['time']}{$item['time']}{/if}</p>
                            {/if}
                            {if $item['author']}
                                <p>责任人/企业：{$item['author']}</p>
                            {/if}
                            <p>{$item['content']}</p>
                        </div>
                    </li>
                {/foreach}

            </ul>
        </div>
    </article>


    <footer>
        <ul class="menubar">
            <li class="tab active" data-role="tab" href="#product-detail" data-toggle="article">
                <i class="icon icon-earth-fill"></i>
                <label class="tab-label">产品信息</label>
            </li>
            <li class="tab" data-role="tab" href="#trace-detail" data-toggle="article">
                <i class="icon icon-lorry-fill"></i>
                <label class="tab-label">溯源详情</label>
            </li>
        </ul>
    </footer>
</section>

<script type="application/javascript">
(function(){
    function autoCheckImgWidth() {
        $('img').each(function(){
            if ($(this).width() > 300) {
                $(this).attr('width', '100%');
            }
        });
    }
    setInterval(function(){
        autoCheckImgWidth();
    }, 500);

    /*
    // 切换顶部标题
    $('footer ul.menubar li').click(function(){
        $('div.titlebar h1').text($(this).text().trim());
    });
    */
})();
</script>

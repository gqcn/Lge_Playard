<section id="section-default" data-role="section" class="active">
    {* 产品详情 *}
    <article data-role="article" id="product-detail" class="default-article active">
        <div class="scroller">
            <div id="product-detail-content">
                {$data['content']}
            </div>
        </div>
    </article>

    {* 溯源详情 *}
    <article data-role="article" id="trace-detail">
        <div class="scroller">
            <div class="card">
                <ul class="table-view">
                    <li class="table-view-cell table-view-divider">Base</li>
                    <li class="table-view-cell"><a class="navigate-right" data-toggle="section" href="#ratchet_layout_section">基本布局</a></li>
                    <li class="table-view-cell"><a class="navigate-right" data-toggle="section" href="#ratchet_button_section">按钮组件</a></li>
                    <li class="table-view-cell"><a class="navigate-right" data-toggle="section" href="#ratchet_list_section">列表组件</a></li>
                    <li class="table-view-cell table-view-divider">Others</li>
                    <li class="table-view-cell"><a class="navigate-right" data-toggle="section" href="#ratchet_form_section">表单样式</a></li>
                    <li class="table-view-cell"><a class="navigate-right" data-toggle="section" href="#ratchet_icon_section">字体图</a></li>
                </ul>
            </div>
        </div>
    </article>


    <nav class="bar bar-tab">
        <a class="tab-item active" data-role="tab" data-toggle="article" href="#product-detail">
            <span class="icon icon-pages"></span>
            <span class="tab-label">产品信息</span>
        </a>
        <a class="tab-item" data-role="tab" data-toggle="article" href="#trace-detail">
            <span class="icon icon-person"></span>
            <span class="tab-label">溯源详情</span>
        </a>
    </nav>
</section>

<script type="application/javascript">
(function(){
    $('article').on('articleload', function(){
        $('#end-study-button').on(A.options.clickEvent, function(e){
            A.confirm('您确定结束学习么？', function(){
                window.location.href="/study/showEnd";
            });
            return false;
        });

        var scroll = A.Scroll(this, {probeType:2});
        setTimeout(function(){
            A.Scroll('article').refresh();
        }, 1000);

        setTimeout(function(){
            checkStatus();
        }, 5000);
    });
})();
</script>

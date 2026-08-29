<?php /*a:2:{s:73:"D:\code\part-time-vue\parttime.com\application\admin\view\index\main.html";i:1701667148;s:67:"D:\code\part-time-vue\parttime.com\application\admin\view\main.html";i:1703403746;}*/ ?>
<div class="layui-card"><style>
        .layui-tab-card>.layui-tab-title .layui-this {
            background-color: #fff;
        }
    </style><?php if(!(empty($title) || (($title instanceof \think\Collection || $title instanceof \think\Paginator ) && $title->isEmpty()))): ?><div class="layui-card-header layui-anim layui-anim-fadein notselect"><span class="layui-icon layui-icon-next font-s10 color-desc margin-right-5"></span><?php echo htmlentities((isset($title) && ($title !== '')?$title:'')); ?><div class="pull-right"></div></div><?php endif; ?><div class="layui-card-body layui-anim layui-anim-upbit"><style>    .store-total-container {
        font-size: 14px;
        margin-bottom: 20px;
        letter-spacing: 1px;
    }

    .store-total-container .store-total-icon {
        top: 45%;
        right: 8%;
        font-size: 65px;
        position: absolute;
        color: rgba(255, 255, 255, 0.4);
    }

    .store-total-container .store-total-item {
        color: #fff;
        line-height: 4em;
        padding: 15px 25px;
        position: relative;
    }

    .store-total-container .store-total-item > div:nth-child(2) {
        font-size: 46px;
        line-height: 46px;
    }

    .num2 {
        font-size: 20px;
        font-weight: bold;
        line-height: 100%
    }

    .store-total-container .store-total-item > div:nth-child(2) {
        font-size: 26px;
        line-height: 36px;
        font-weight: bold;
    }

    .store-total-container .store-total-item {
        line-height: 2em
    }
</style><div class="think-box-shadow store-total-container"><h4 style="text-align: center">当地时间： <?php echo date('Y-m-d H:i:s'); ?></h4><!--<div class="margin-bottom-15">商城统计</div>--><fieldset><legend>商城统计</legend><form class="layui-form layui-form-pane form-search" action="<?php echo request()->url(); ?>" onsubmit="return false"
          method="get" autocomplete="off"><div class="layui-form-item layui-inline"><label class="layui-form-label">时间</label><div class="layui-input-inline"><input data-date id="query-date" name="date" value="<?php echo htmlentities((app('request')->get('date') ?: '')); ?>" placeholder="请选择时间"
                       class="layui-input"></div></div><div class="layui-form-item layui-inline"><button class="layui-btn layui-btn-primary"><i class="layui-icon">&#xe615;</i> 查 询</button></div></form></fieldset><div class="layui-row layui-col-space15" id="shop_content">加载中....</div></div><div id="agent_content">
    加载中......
</div><script>
    $(function () {
        $.ajax({
            url: "<?php echo url('main'); ?>",
            data: {type: "shop", date:$('#query-date').val()},
            type: 'get',
            success: function (res) {
                $('#shop_content').html(res);
                get_agent();
            }
        });
        function get_agent()
        {
            $.ajax({
                url: "<?php echo url('main'); ?>",
                data: {type: "agent"},
                type: 'get',
                success: function (res) {
                    $('#agent_content').html(res);
                    $.form.reInit();
                }
            });
        }
    });
</script></div></div><script>
//    layui.use('element', function(){
//        var element = layui.element;
//
//        element.tabAdd('demo', {
//            title: '选项卡的标题'
//            ,content: '选项卡的内容' //支持传入html
//            ,id: '选项卡标题的lay-id属性值'
//        });
//
//        //获取hash来切换选项卡，假设当前地址的hash为lay-id对应的值
//        var layid = location.hash.replace(/^#test1=/, '');
//        element.tabChange('test1', layid); //假设当前地址为：http://a.com#test1=222，那么选项卡会自动切换到“发送消息”这一项
//
//        //监听Tab切换，以改变地址hash值
//        element.on('tab(test1)', function(){
//            location.hash = ''+ this.getAttribute('lay-id');
//        });
//    });

</script>
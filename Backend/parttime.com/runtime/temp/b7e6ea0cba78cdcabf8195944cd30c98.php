<?php /*a:2:{s:77:"D:\code\part-time-vue\parttime.com\application\admin\view\usetting\index.html";i:1630989930;s:67:"D:\code\part-time-vue\parttime.com\application\admin\view\main.html";i:1703403746;}*/ ?>
<div class="layui-card"><style>
        .layui-tab-card>.layui-tab-title .layui-this {
            background-color: #fff;
        }
    </style><?php if(!(empty($title) || (($title instanceof \think\Collection || $title instanceof \think\Paginator ) && $title->isEmpty()))): ?><div class="layui-card-header layui-anim layui-anim-fadein notselect"><span class="layui-icon layui-icon-next font-s10 color-desc margin-right-5"></span><?php echo htmlentities((isset($title) && ($title !== '')?$title:'')); ?><div class="pull-right"><?php if(auth("add")): ?><button data-modal='<?php echo url("add"); ?>?uid=<?php echo htmlentities($uid); ?>' data-title="添加设置" class='layui-btn layui-btn-sm layui-btn-primary'>添加设置</button><?php endif; ?></div></div><?php endif; ?><div class="layui-card-body layui-anim layui-anim-upbit"><div class="think-box-shadow"><p class="help-block">如果用户加入了叠加组，设置无法生效</p><table class="layui-table margin-top-10" lay-skin="line"><?php if(!(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty()))): ?><thead><tr><th class='text-left nowrap'>ID</th><th class='text-left nowrap'>UID</th><th class='text-left nowrap'>日期</th><th class='text-left nowrap'>可做单数</th><th class='text-left nowrap'>佣金比例</th><th class='text-left nowrap'>最低金额</th><th class='text-left nowrap'>完成多少单可提现</th><th class='text-left nowrap'>创建时间</th><th class='text-left nowrap'></th></tr></thead><?php endif; ?><tbody><?php foreach($list as $key=>$vo): ?><tr data-dbclick><td class='text-left nowrap'><?php echo htmlentities($vo['id']); ?></td><td class='text-left nowrap'><?php echo htmlentities($vo['uid']); ?></td><td class='text-left nowrap'><?php echo htmlentities($vo['date']); ?></td><td class='text-left nowrap'><?php echo htmlentities($vo['order_num']); ?></td><td class='text-left nowrap'><?php echo htmlentities($vo['bili']); ?></td><td class='text-left nowrap'><?php echo htmlentities($vo['min_money']); ?></td><td class='text-left nowrap'><?php echo htmlentities($vo['min_deposit_order']); ?></td><td class='text-left nowrap'><?php echo htmlentities($vo['create_at']); ?></td><td class='text-left nowrap'><?php if(auth("edit")): ?><a data-dbclick class="layui-btn layui-btn-sm" data-title="编辑"
                   data-modal='<?php echo url("edit"); ?>?id=<?php echo htmlentities($vo['id']); ?>'>编辑</a><?php endif; ?></td></tr><?php endforeach; ?></tbody></table><?php if(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty())): ?><span class="notdata">没有记录哦</span><?php else: ?><?php echo (isset($pagehtml) && ($pagehtml !== '')?$pagehtml:''); ?><?php endif; ?></div></div></div><script>
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
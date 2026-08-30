<?php /*a:2:{s:80:"D:\freelance\kkk577\Backend\parttime.com\application\admin\view\group\index.html";i:1787941024;s:73:"D:\freelance\kkk577\Backend\parttime.com\application\admin\view\main.html";i:1787941022;}*/ ?>
<div class="layui-card"><style>
        .layui-tab-card>.layui-tab-title .layui-this {
            background-color: #fff;
        }
    </style><?php if(!(empty($title) || (($title instanceof \think\Collection || $title instanceof \think\Paginator ) && $title->isEmpty()))): ?><div class="layui-card-header layui-anim layui-anim-fadein notselect"><span class="layui-icon layui-icon-next font-s10 color-desc margin-right-5"></span><?php echo htmlentities((isset($title) && ($title !== '')?$title:'')); ?><div class="pull-right"><?php if(auth("add")): ?><button data-modal='<?php echo url("add"); ?>' data-title="添加分组" class='layui-btn layui-btn-sm layui-btn-primary'>添加分组</button><?php endif; ?></div></div><?php endif; ?><div class="layui-card-body layui-anim layui-anim-upbit"><div class="think-box-shadow"><p class="help-block">添加分组后，必须添加规则，并且规则需要对应好订单个数，若出现不对称情况，会导致用户无法做单</p><table class="layui-table margin-top-10" lay-skin="line"><?php if(!(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty()))): ?><thead><tr><th class='list-table-check-td think-checkbox'><label><input data-auto-none data-check-target='.list-check-box' type='checkbox'></label></th><th class='text-left nowrap'>所属代理</th><th class='text-left nowrap'>名称</th><th class='text-left nowrap'>最低金额</th><th class='text-left nowrap'>最低佣金比例</th><th class='text-left nowrap'>订单数量</th><th class='text-left nowrap'>规则数量</th><th class='text-left nowrap'>用户数量</th><th class='text-left nowrap'>允许轮回</th><th class='text-left nowrap'></th></tr></thead><?php endif; ?><tbody><?php foreach($list as $key=>$vo): ?><tr data-dbclick><td class='list-table-check-td think-checkbox'><label><input class="list-check-box" value='<?php echo htmlentities($vo['id']); ?>' type='checkbox'></label></td><td class='text-left nowrap'><?php echo htmlentities($agentList[$vo['agent_id']]); ?></td><td class='text-left nowrap'><?php echo htmlentities((isset($vo['title']) && ($vo['title'] !== '')?$vo['title']:'')); ?></td><td class='text-left nowrap'><?php echo htmlentities((isset($vo['money']) && ($vo['money'] !== '')?$vo['money']:'0')); ?></td><td class='text-left nowrap'><?php echo htmlentities((isset($vo['bili']) && ($vo['bili'] !== '')?$vo['bili']:'0')); ?>%</td><td class='text-left nowrap'><?php echo htmlentities((isset($vo['order_num']) && ($vo['order_num'] !== '')?$vo['order_num']:'0')); ?></td><td class='text-left nowrap'><?php echo htmlentities((isset($vo['rule_count']) && ($vo['rule_count'] !== '')?$vo['rule_count']:'0')); ?></td><td class='text-left nowrap'><?php echo htmlentities((isset($vo['user_count']) && ($vo['user_count'] !== '')?$vo['user_count']:'0')); ?></td><td class='text-left nowrap'><?php if($vo['is_roll']==1): ?>
                允许
                <?php else: ?>
                不允许
                <?php endif; ?></td><td class='text-left nowrap'><?php if(auth("rule")): ?><a data-dbclick class="layui-btn layui-btn-sm" data-title="叠加规则列表"
                   data-open='<?php echo url("rule"); ?>?group_id=<?php echo htmlentities($vo['id']); ?>'>规则</a><?php endif; if(auth("edit")): ?><a data-dbclick class="layui-btn layui-btn-sm" data-title="编辑分组"
                   data-modal='<?php echo url("edit"); ?>?id=<?php echo htmlentities($vo['id']); ?>'>编辑</a><?php endif; if(auth("remove")): ?><a class="layui-btn layui-btn-sm layui-btn-danger" data-confirm="确定要删除吗？"
                   data-action="<?php echo url('remove'); ?>" data-value="id#<?php echo htmlentities($vo['id']); ?>" data-csrf="<?php echo systoken('remove'); ?>">删除</a><?php endif; ?></td></tr><?php endforeach; ?></tbody></table><?php if(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty())): ?><span class="notdata">没有记录哦</span><?php else: ?><?php echo (isset($pagehtml) && ($pagehtml !== '')?$pagehtml:''); ?><?php endif; ?></div></div></div><script>
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
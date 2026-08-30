<?php /*a:2:{s:80:"D:\freelance\kkk577\Backend\parttime.com\application\admin\view\agent\index.html";i:1787941022;s:73:"D:\freelance\kkk577\Backend\parttime.com\application\admin\view\main.html";i:1787941022;}*/ ?>
<div class="layui-card"><style>
        .layui-tab-card>.layui-tab-title .layui-this {
            background-color: #fff;
        }
    </style><?php if(!(empty($title) || (($title instanceof \think\Collection || $title instanceof \think\Paginator ) && $title->isEmpty()))): ?><div class="layui-card-header layui-anim layui-anim-fadein notselect"><span class="layui-icon layui-icon-next font-s10 color-desc margin-right-5"></span><?php echo htmlentities((isset($title) && ($title !== '')?$title:'')); ?><div class="pull-right"><?php if(auth("add")): ?><button data-modal='<?php echo url("add"); ?>' data-title="添加代理" class='layui-btn layui-btn-sm layui-btn-primary'>添加代理</button><?php endif; ?></div></div><?php endif; ?><div class="layui-card-body layui-anim layui-anim-upbit"><div class="think-box-shadow"><fieldset><legend>条件搜索</legend><form class="layui-form layui-form-pane form-search" action="<?php echo request()->url(); ?>" onsubmit="return false"
              method="get" autocomplete="off"><div class="layui-form-item layui-inline"><label class="layui-form-label">用户名称</label><div class="layui-input-inline"><input name="username" value="<?php echo htmlentities((app('request')->get('username') ?: '')); ?>" placeholder="请输入用户名称"
                           class="layui-input"></div></div><div class="layui-form-item layui-inline"><label class="layui-form-label">手机号码</label><div class="layui-input-inline"><input name="phone" value="<?php echo htmlentities((app('request')->get('tel') ?: '')); ?>" placeholder="请输入手机号码" class="layui-input"></div></div><div class="layui-form-item layui-inline"><button class="layui-btn layui-btn-primary"><i class="layui-icon">&#xe615;</i> 搜 索</button></div></form></fieldset><script>form.render()</script><table class="layui-table margin-top-10" lay-skin="line"><?php if(!(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty()))): ?><thead><tr><th class='text-left nowrap'>ID</th><th class='text-left nowrap'>绑定用户ID</th><th class='text-left nowrap'>级别</th><th class='text-left nowrap'>用户名</th><th class='text-left nowrap'>手机号</th><th class='text-left nowrap'>推广地址</th><th class='text-left nowrap'>邀请码</th><th class='text-center nowrap'>登录次数</th><th class='text-center nowrap'>使用状态</th><th class='text-left nowrap'>客服链接</th><th class='text-left nowrap'>添加时间</th><th class='text-left nowrap'></th></tr></thead><?php endif; ?><tbody><?php foreach($list as $key=>$vo): ?><tr data-dbclick><td class='text-left nowrap'><?php echo htmlentities($vo['id']); ?></td><td class='text-left nowrap'><?php echo htmlentities($vo['user_id']); ?></td><td class='text-left nowrap'><?php if($vo['parent_id']==0): ?>一级<?php else: ?>二级<?php endif; ?></td><td class='text-left nowrap'><?php echo htmlentities($vo['username']); ?></td><td class='text-left nowrap'><?php echo htmlentities($vo['phone']); ?></td><td class='text-left nowrap'><a href="//<?php echo htmlentities($vo['username']); ?>.<?php echo request()->rootDomain()?>" target="_blank"><?php echo htmlentities($vo['username']); ?>.<?php echo request()->rootDomain()?></a></td><td class='text-center nowrap'><?php echo htmlentities($vo['invite_code']); ?></td><td class='text-center nowrap'><?php echo htmlentities((isset($vo['login_num']) && ($vo['login_num'] !== '')?$vo['login_num']:0)); ?></td><td class='text-center nowrap'><?php if($vo['status'] == '0'): ?><span class="color-red">已禁用</span><?php else: ?><span
                    class="color-green">使用中</span><?php endif; ?></td><td class='text-left nowrap'><?php echo htmlentities($vo['chats']); ?></td><td class='text-left nowrap'><?php echo htmlentities($vo['create_at']); ?></td><td class='text-left nowrap'><?php if($is_admin && $vo['parent_id']==0): ?><a class="layui-btn layui-btn-normal layui-btn-sm" data-title="设置密码"
                   data-open='<?php echo url("index"); ?>?parent_id=<?php echo htmlentities($vo['id']); ?>'>下级</a><?php endif; if(auth("pass")): ?><a class="layui-btn layui-btn-normal layui-btn-sm" data-title="设置密码"
                   data-modal='<?php echo url("pass"); ?>?id=<?php echo htmlentities($vo['id']); ?>'>密 码</a><?php endif; if(auth("edit")): ?><a data-dbclick class="layui-btn layui-btn-sm" data-title="编辑"
                   data-modal='<?php echo url("edit"); ?>?id=<?php echo htmlentities($vo['id']); ?>'>编 辑</a><?php endif; if($vo['status'] == 1 and auth("forbid")): ?><a class="layui-btn layui-btn-sm layui-btn-warm" data-action="<?php echo url('forbid'); ?>"
                   data-value="id#<?php echo htmlentities($vo['id']); ?>;status#0" data-csrf="<?php echo systoken('forbid'); ?>">禁 用</a><?php elseif($vo['status'] == 0 and auth("resume")): ?><a class="layui-btn layui-btn-sm layui-btn-warm" data-action="<?php echo url('resume'); ?>"
                   data-value="id#<?php echo htmlentities($vo['id']); ?>;status#1" data-csrf="<?php echo systoken('resume'); ?>">启 用</a><?php endif; ?></td></tr><?php endforeach; ?></tbody></table><?php if(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty())): ?><span class="notdata">没有记录哦</span><?php else: ?><?php echo (isset($pagehtml) && ($pagehtml !== '')?$pagehtml:''); ?><?php endif; ?></div></div></div><script>
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
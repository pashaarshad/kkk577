<?php /*a:3:{s:80:"D:\freelance\kkk577\Backend\parttime.com\application\admin\view\users\index.html";i:1787941028;s:73:"D:\freelance\kkk577\Backend\parttime.com\application\admin\view\main.html";i:1787941022;s:87:"D:\freelance\kkk577\Backend\parttime.com\application\admin\view\users\index_search.html";i:1787941028;}*/ ?>
<div class="layui-card"><style>
        .layui-tab-card>.layui-tab-title .layui-this {
            background-color: #fff;
        }
    </style><?php if(!(empty($title) || (($title instanceof \think\Collection || $title instanceof \think\Paginator ) && $title->isEmpty()))): ?><div class="layui-card-header layui-anim layui-anim-fadein notselect"><span class="layui-icon layui-icon-next font-s10 color-desc margin-right-5"></span><?php echo htmlentities((isset($title) && ($title !== '')?$title:'')); ?><div class="pull-right"><?php if(auth("add_users")): ?><button data-modal='<?php echo url("add_users"); ?>' data-title="添加会员" class='layui-btn layui-btn-sm layui-btn-primary'>添加会员</button><?php endif; ?></div></div><?php endif; ?><div class="layui-card-body layui-anim layui-anim-upbit"><div class="think-box-shadow"><form class="layui-form layui-form-pane form-search" action="<?php echo request()->url(); ?>" onsubmit="return false" method="get"
      autocomplete="off"><div class="layui-form-item layui-inline"><label class="layui-form-label">一级代理</label><div class="layui-input-inline"><select name="agent_id"><option value="0">全部</option><?php foreach($agent_list as $k=>$v): ?><option value="<?php echo htmlentities($k); ?>"<?php if($agent_id==$k): ?> selected<?php endif; ?>><?php echo htmlentities($v); ?></option><?php endforeach; ?></select></div></div><div class="layui-form-item layui-inline"><label class="layui-form-label">二级代理</label><div class="layui-input-inline"><select name="agent_service_id"><option value="0">全部</option><?php foreach($agent_service_list as $k=>$v): ?><option value="<?php echo htmlentities($k); ?>"<?php if($agent_service_id==$k): ?> selected<?php endif; ?>><?php echo htmlentities($v); ?></option><?php endforeach; ?></select></div></div><div class="layui-form-item layui-inline"><label class="layui-form-label">级别</label><div class="layui-input-inline"><select name="level"><option value="-1">全部级别</option><?php foreach($level_list as $vo): ?><option value="<?php echo htmlentities($vo['level']); ?>" {if $level==$vo.level} selected{
                /if}><?php echo htmlentities($vo['name']); ?></option><?php endforeach; ?></select></div></div><div class="layui-form-item layui-inline"><label class="layui-form-label">叠加组</label><div class="layui-input-inline"><select name="group_id"><option value="-1">全部叠加组</option><?php foreach($groupList as $k=>$vo): ?><option value="<?php echo htmlentities($k); ?>" {if $group_id==$k} selected{
                /if}><?php echo htmlentities($vo); ?></option><?php endforeach; ?></select></div></div><div class="layui-form-item layui-inline"><label class="layui-form-label">状态</label><div class="layui-input-inline"><select name="is_jia" id="selectList"><option value="">所有状态</option><option value="-1">真人</option><option value="1">假人</option></select></div></div><div class="layui-form-item layui-inline"><label class="layui-form-label">排序方式</label><div class="layui-input-inline"><select name="order"><option value="">默认排序</option><option value="recharge" {if $order=='recharge'} selected{
                /if}>充值金额倒序</option><option value="recharge_count" {if $order=='recharge_count'} selected{
                /if}>充值次数倒序</option><option value="deposit" {if $order=='deposit'} selected{
                /if}>提现金额倒序</option><option value="deposit_count" {if $order=='deposit_count'} selected{
                /if}>提现次数倒序</option></select></div></div><div class="layui-form-item layui-inline"><label class="layui-form-label">用户名称</label><div class="layui-input-inline"><input name="username" value="<?php echo htmlentities((app('request')->get('username') ?: '')); ?>" placeholder="请输入用户名称" class="layui-input"></div></div><div class="layui-form-item layui-inline"><label class="layui-form-label">手机号码</label><div class="layui-input-inline"><input name="tel" value="<?php echo htmlentities((app('request')->get('tel') ?: '')); ?>" placeholder="请输入手机号码" class="layui-input"></div></div><div class="layui-form-item layui-inline"><label class="layui-form-label">邀请码</label><div class="layui-input-inline"><input name="invite_code" value="<?php echo htmlentities((app('request')->get('invite_code') ?: '')); ?>" placeholder="邀请码" class="layui-input"></div></div><div class="layui-form-item layui-inline"><label class="layui-form-label">注册时间</label><div class="layui-input-inline"><input data-date-range name="addtime" value="<?php echo htmlentities((app('request')->get('addtime') ?: '')); ?>" placeholder="请选择注册时间"
                   class="layui-input"></div></div><div class="layui-form-item layui-inline"><button class="layui-btn layui-btn-primary"><i class="layui-icon">&#xe615;</i> 搜 索</button><?php if(auth("daochu")): ?><a href="<?php echo url('daochu'); ?>" class="layui-btn layui-btn-danger"><i class="layui-icon">&#xe615;</i> 导 出</a><?php endif; ?></div></form><div class="layui-form layui-form-pane form-search"><?php if(auth("inyectar/batch_inyectar")): ?><div class="layui-form-item layui-inline"><label class="layui-form-label">打针幅度</label><div class="layui-input-inline"><input id="in_cale" value="" type="number" placeholder="最低 1.1" class="layui-input"></div></div><div class="layui-form-item layui-inline"><a data-post='<?php echo url("inyectar/batch_inyectar"); ?>'
           data-csrf="<?php echo systoken('inyectar/batch_inyectar'); ?>"
           onclick="set_inyectar(this)"
           class="layui-btn layui-btn-danger">批量打针
        </a></div><?php endif; ?></div><script>
    function set_inyectar(el) {
        var sel = table.checkStatus('userTable');
        var ids = [];
        var $this = $(el);
        for (var i = 0; i < sel.data.length; i++) ids.push(sel.data[i].id);
        if (ids.length < 1) return $.msg.tips('请选择要打针的用户！');
        var data = {};
        data.uids = ids;
        data.scale = $('#in_cale').val();
        data.scale = data.scale.length > 0 ? parseFloat(data.scale) : 0;
        if (data.scale < 1.1) return $.msg.tips('请输入打针比例！');
        console.log(data);

        $.msg.confirm('确定打针？', function () {
            $.form.load($this.attr('data-post'), data, 'post',false, true);
        });
    }

    var test = "<?php echo htmlentities((app('request')->get('is_jia') ?: '0')); ?>";
    $("#selectList").find("option[value=" + test + "]").prop("selected", true);
    form.render()
</script><table class="layui-table margin-top-15" id="userTable" lay-filter="tab" lay-skin="line"><?php if(!(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty()))): ?><thead><tr><th lay-data="{type:'checkbox',width:40,fixed:'left'}" class='list-table-check-td think-checkbox'><label><input data-auto-none data-check-target='.list-check-box' type='checkbox'></label></th><th lay-data="{field:'id',width:80,fixed:'left'}" class='text-left nowrap'>UID</th><th lay-data="{field:'addtime',width:170}" class='text-left nowrap'>注册时间</th><th lay-data="{field:'agent',width:90}" class='text-left nowrap'>一级代理</th><th lay-data="{field:'service',width:120}" class='text-left nowrap'>二级代理</th><th lay-data="{field:'tel'}" class='text-left nowrap'>账号</th><th lay-data="{field:'username',width:140}" class='text-left nowrap'>用户名</th><th lay-data="{field:'level',width:80}" class='text-left nowrap'>等级</th><th lay-data="{field:'group_id',width:150}" class='text-left nowrap'>规则组</th><th lay-data="{field:'balance'}" class='text-left nowrap'>账户余额</th><th lay-data="{field:'credit_score',width:90}" class='text-left nowrap'>信用分</th><th lay-data="{field:'risk_score',width:90}" class='text-left nowrap'>风险分</th><th lay-data="{field:'com'}" class='text-left nowrap'>佣金</th><th lay-data="{field:'tj_com'}" class='text-left nowrap'>下级佣金</th><th lay-data="{field:'all_recharge_num'}" class='text-left nowrap'>累计充值金额</th><th lay-data="{field:'all_recharge_count'}" class='text-left nowrap'>累计充值次数</th><th lay-data="{field:'all_deposit_num'}" class='text-left nowrap'>累计提现金额</th><th lay-data="{field:'all_deposit_count'}" class='text-left nowrap'>累计提现次数</th><th lay-data="{field:'freeze_balance'}" class='text-left nowrap'>冻结金额</th><!--            <th lay-data="{field:'lixibao_balance'}" class='text-left nowrap'>利息宝金额</th>--><th lay-data="{field:'parent_name'}" class='text-left nowrap'>上级用户</th><th lay-data="{field:'invite_code'}" class='text-left nowrap'>邀请码</th><th lay-data="{field:'ip'}" class='text-left nowrap'>最后登录ip</th><th lay-data="{field:'is_jia',width:80}" class='text-left nowrap'>状态</th><th lay-data="{field:'edit',width:250,fixed: 'right'}" class='text-left nowrap'>操作</th></tr></thead><?php endif; ?><tbody><?php foreach($list as $key=>$vo): ?><tr><td class='list-table-check-td think-checkbox'><label><input class="list-check-box" value='<?php echo htmlentities($vo['id']); ?>' type='checkbox'></label></td><td class='text-left nowrap'><?php echo htmlentities($vo['id']); ?></td><td class='text-left nowrap'><?php echo htmlentities(format_datetime($vo['addtime'])); ?></td><td class='text-left nowrap'><?php echo htmlentities($vo['agent']); ?></td><td class='text-left nowrap'><?php echo htmlentities($vo['service']); ?></td><td class='text-left nowrap'><?php echo htmlentities($vo['tel']); ?></td><td class='text-left nowrap'><?php echo htmlentities($vo['username']); if($vo['remark']): ?><span style="color:#f00">（<?php echo htmlentities($vo['remark']); ?>）</span><?php endif; ?></td><td class='text-left nowrap'>VIP<?php echo htmlentities($vo['level']); ?></td><td class='text-left nowrap'><?php if($vo['group_id']): ?><?php echo htmlentities($groupAllList[$vo['group_id']]); else: ?>-<?php endif; ?></td><td class='text-left nowrap'><?php echo htmlentities($vo['balance']); ?></td><td class='text-left nowrap'><?php echo htmlentities((isset($vo['credit_score']) && ($vo['credit_score'] !== '')?$vo['credit_score']:0)); ?></td><td class='text-left nowrap'><?php echo htmlentities((isset($vo['risk_score']) && ($vo['risk_score'] !== '')?$vo['risk_score']:0)); ?></td><td class='text-left nowrap'><?php echo htmlentities($vo['com']); ?></td><td class='text-left nowrap'><?php echo htmlentities($vo['tj_com']); ?></td><td class='text-left nowrap'><?php echo htmlentities($vo['all_recharge_num']); ?></td><td class='text-left nowrap'><?php echo htmlentities($vo['all_recharge_count']); ?></td><td class='text-left nowrap'><?php echo htmlentities($vo['all_deposit_num']); ?></td><td class='text-left nowrap'><?php echo htmlentities($vo['all_deposit_count']); ?></td><td class='text-left nowrap'><?php echo htmlentities($vo['freeze_balance']); ?></td><!--            <td class='text-left nowrap'><?php echo htmlentities($vo['lixibao_balance']); ?></td>--><td class='text-left nowrap'><?php echo htmlentities($vo['parent_name']); ?></td><td class='text-left nowrap'><?php echo htmlentities($vo['invite_code']); ?></td><td class='text-left nowrap'><?php echo htmlentities($vo['ip']); ?></td><td class='text-left nowrap'><?php if($vo['is_jia']>0): ?><a class="layui-btn layui-btn-danger layui-btn-xs">假人</a><?php else: ?><a class="layui-btn layui-btn-normal layui-btn-xs">真人</a><?php endif; ?></td><td class='text-left nowrap'><a data-csrf="<?php echo systoken('do_user_orders'); ?>" class="layui-btn layui-btn-xs layui-btn-danger"
                   data-confirm="确定将该用户所有待付款订单强制付款吗?"
                   data-action="<?php echo url('do_user_orders'); ?>" data-value="id#<?php echo htmlentities($vo['id']); ?>" style='background:red;'>强制付款</a><?php if(auth("edit_users")): ?><a data-dbclick class="layui-btn layui-btn-xs layui-btn-danger" data-title="编辑用户信息" style='background:red;'
                   data-modal='<?php echo url("users/edit_users"); ?>?id=<?php echo htmlentities($vo['id']); ?>'>编辑</a><?php endif; if(auth("edit_level")): ?><a data-dbclick class="layui-btn layui-btn-xs" data-title="编辑等级"
                   data-modal='<?php echo url("users/edit_level"); ?>?id=<?php echo htmlentities($vo['id']); ?>'>等级</a><?php endif; if(auth("edit_money")): ?><a data-dbclick class="layui-btn layui-btn-xs layui-btn-danger" data-title="编辑余额信息"
                   style='background:red;'
                   data-modal='<?php echo url("users/edit_money"); ?>?id=<?php echo htmlentities($vo['id']); ?>'>余额</a><?php endif; ?><a data-dbclick class="layui-btn layui-btn-xs" data-title="用户备注"
                   data-modal='<?php echo url("users/edit_users_remark"); ?>?id=<?php echo htmlentities($vo['id']); ?>'>备注</a><?php if(auth("edit_users_ankou")): ?><!--<a data-dbclick class="layui-btn layui-btn-xs layui-btn-danger" data-title="暗扣设置"
                   data-modal='<?php echo url("users/edit_users_ankou"); ?>?id=<?php echo htmlentities($vo['id']); ?>'>暗扣设置</a>--><?php endif; if(auth("inyectar/index")): ?><!--<a data-dbclick class="layui-btn layui-btn-xs layui-btn-danger" data-title="打针计划"--><!--   data-open='<?php echo url("inyectar/index"); ?>?uid=<?php echo htmlentities($vo['id']); ?>'>打针</a>--><?php endif; if(auth("usetting/index")): ?><a data-dbclick class="layui-btn layui-btn-xs layui-btn-normal" data-title="做单设置"
                   data-open='<?php echo url("usetting/index"); ?>?uid=<?php echo htmlentities($vo['id']); ?>'>做单</a><?php endif; if(auth("edit_users_bk")): ?><a data-dbclick class="layui-btn layui-btn-xs" data-title="银行卡信息"
                   data-modal='<?php echo url("users/edit_users_bk"); ?>?id=<?php echo htmlentities($vo['id']); ?>'>银行卡信息</a><?php endif; ?><!--<?php if(auth("edit_users_address")): ?><a data-dbclick class="layui-btn layui-btn-xs layui-btn-danger" data-title="收货地址信息"
                   data-modal='<?php echo url("users/edit_users_address"); ?>?id=<?php echo htmlentities($vo['id']); ?>'>地址信息</a><?php endif; ?>--><?php if(auth("edit_users_ewm")): ?><!--<a class="layui-btn layui-btn-xs layui-btn"
                   data-action="<?php echo url('edit_users_ewm',['status'=>2,'id'=>$vo['id']]); ?>"
                   data-value="id#<?php echo htmlentities($vo['id']); ?>;status#<?php echo htmlentities($vo['invite_code']); ?>" style='background:red;'>刷新二维码</a>--><?php endif; if(auth("tuandui")): ?><a data-dbclick class="layui-btn layui-btn-xs layui-btn-danger" data-title="查看团队" data-reload="true"
                   data-open='<?php echo url("users/tuandui"); ?>?id=<?php echo htmlentities($vo['id']); ?>'>查看团队</a><a data-dbclick class="layui-btn layui-btn-xs layui-btn-normal" data-title="查看账变" data-reload="true"
                   data-open='<?php echo url("users/caiwu"); ?>?id=<?php echo htmlentities($vo['id']); ?>'>账变</a><?php endif; if(($vo['status'] == 1) and auth("edit_users_status")): ?><a class="layui-btn layui-btn-xs layui-btn-warm"
                   data-action="<?php echo url('edit_users_status',['status'=>2,'id'=>$vo['id']]); ?>"
                   data-value="id#<?php echo htmlentities($vo['id']); ?>;status#2" style='background:red;'>禁用</a><?php elseif(($vo['status'] == 2) and auth("edit_users_status")): ?><a class="layui-btn layui-btn-xs layui-btn-warm"
                   data-action="<?php echo url('edit_users_status',['status'=>1,'id'=>$vo['id']]); ?>"
                   data-value="id#<?php echo htmlentities($vo['id']); ?>;status#1" style='background:green;'>启用</a><?php endif; if(auth("delete_user")): ?><a class="layui-btn layui-btn-xs layui-btn" onClick="del_user(<?php echo htmlentities($vo['id']); ?>)" style='background:red;'>删除</a><?php endif; if(auth("edit_users_status")): if(($vo['is_jia'] == 1)): ?><a class="layui-btn layui-btn-xs layui-btn-warm"
                   data-action="<?php echo url('edit_users_status2',['status'=>-1,'id'=>$vo['id']]); ?>"
                   data-value="id#<?php echo htmlentities($vo['id']); ?>;status#-1" style='background:red;'>设为真人</a><?php else: ?><a class="layui-btn layui-btn-xs layui-btn-warm"
                   data-action="<?php echo url('edit_users_status2',['status'=>1,'id'=>$vo['id']]); ?>"
                   data-value="id#<?php echo htmlentities($vo['id']); ?>;status#1" style='background:green;'>设为假人</a><?php endif; ?><?php endif; ?></td></tr><?php endforeach; ?></tbody></table><script>
        function del_user(id) {
            layer.confirm("确认要删除吗，删除后不能恢复", {title: "删除确认"}, function (index) {
                $.ajax({
                    type: 'POST',
                    url: "<?php echo url('delete_user'); ?>",
                    data: {
                        'id': id,
                        '_csrf_': "<?php echo systoken('delete_user'); ?>"
                    },
                    success: function (res) {
                        layer.msg(res.info, {time: 2500});
                        location.reload();
                    }
                });
            }, function () {
            });
        }
    </script><script>
        var table = layui.table;
        //转换静态表格
        var limit = Number('<?php echo htmlentities(app('request')->get('limit')); ?>');
        if (limit == 0) limit = 20;
        table.init('tab', {
            cellMinWidth: 120,
            skin: 'line,row',
            size: 'lg',
            limit: limit
        });
    </script><?php if(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty())): ?><span class="notdata">没有记录哦</span><?php else: ?><?php echo (isset($pagehtml) && ($pagehtml !== '')?$pagehtml:''); ?><?php endif; ?></div></div></div><script>
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
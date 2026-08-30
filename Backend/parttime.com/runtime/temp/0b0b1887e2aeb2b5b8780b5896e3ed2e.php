<?php /*a:2:{s:86:"D:\freelance\kkk577\Backend\parttime.com\application\admin\view\deal\deposit_list.html";i:1787941023;s:73:"D:\freelance\kkk577\Backend\parttime.com\application\admin\view\main.html";i:1787941022;}*/ ?>
<div class="layui-card"><style>
        .layui-tab-card>.layui-tab-title .layui-this {
            background-color: #fff;
        }
    </style><?php if(!(empty($title) || (($title instanceof \think\Collection || $title instanceof \think\Paginator ) && $title->isEmpty()))): ?><div class="layui-card-header layui-anim layui-anim-fadein notselect"><span class="layui-icon layui-icon-next font-s10 color-desc margin-right-5"></span><?php echo htmlentities((isset($title) && ($title !== '')?$title:'')); ?><div class="pull-right"></div></div><?php endif; ?><div class="layui-card-body layui-anim layui-anim-upbit"><div class="think-box-shadow"><fieldset><legend>条件搜索</legend><form class="layui-form layui-form-pane form-search" action="<?php echo request()->url(); ?>" onsubmit="return false"
              method="get" autocomplete="off"><!--
            <?php if(auth("do_deposit")): ?><div class="layui-form-item layui-inline" style="margin-right: 10px"><button data-action='<?php echo url("do_deposit2"); ?>' data-csrf="<?php echo systoken('do_deposit2'); ?>" data-rule="id#{key}"
                        class='layui-btn layui-btn-sm layui-btn-danger'>批量通过
                </button><button data-action='<?php echo url("do_deposit3"); ?>' data-csrf="<?php echo systoken('do_deposit3'); ?>" data-rule="id#{key}"
                        class='layui-btn layui-btn-sm layui-btn-warning'>批量拒绝
                </button></div><?php endif; ?>
            --><div class="layui-form-item layui-inline"><label class="layui-form-label">代理审核</label><div class="layui-input-inline"><select name="agent_status"><option value="">全部</option><option value="1" <?php if($agent_status==1): ?> selected<?php endif; ?>>未审核</option><option value="2" <?php if($agent_status==2): ?> selected<?php endif; ?>>已通过</option><option value="3" <?php if($agent_status==3): ?> selected<?php endif; ?>>已驳回</option></select></div></div><div class="layui-form-item layui-inline"><label class="layui-form-label">状态</label><div class="layui-input-inline"><select name="status"><option value="">全部</option><option value="1" <?php if($status==1): ?> selected<?php endif; ?>>未审核</option><option value="2" <?php if($status==2): ?> selected<?php endif; ?>>已通过</option><option value="3" <?php if($status==3): ?> selected<?php endif; ?>>已驳回</option><option value="4" <?php if($status==4): ?> selected<?php endif; ?>>转账失败</option></select></div></div><div class="layui-form-item layui-inline"><label class="layui-form-label">一级代理</label><div class="layui-input-inline"><select name="agent_id"><option value="0">全部</option><?php foreach($agent_list as $k=>$v): ?><option value="<?php echo htmlentities($k); ?>"<?php if($agent_id==$k): ?> selected<?php endif; ?>><?php echo htmlentities($v); ?></option><?php endforeach; ?></select></div></div><div class="layui-form-item layui-inline"><label class="layui-form-label">二级代理</label><div class="layui-input-inline"><select name="agent_service_id"><option value="0">全部</option><?php foreach($agent_service_list as $k=>$v): ?><option value="<?php echo htmlentities($k); ?>"<?php if($agent_service_id==$k): ?> selected<?php endif; ?>><?php echo htmlentities($v); ?></option><?php endforeach; ?></select></div></div><div class="layui-form-item layui-inline"><label class="layui-form-label">订单号</label><div class="layui-input-inline"><input name="oid" value="<?php echo htmlentities((app('request')->get('oid') ?: '')); ?>" placeholder="请输入订单号" class="layui-input"></div></div><div class="layui-form-item layui-inline"><label class="layui-form-label">用户名称</label><div class="layui-input-inline"><input name="username" value="<?php echo htmlentities((app('request')->get('username') ?: '')); ?>" placeholder="请输入用户名称"
                           class="layui-input"></div></div><div class="layui-form-item layui-inline"><label class="layui-form-label">手机号</label><div class="layui-input-inline"><input name="mobile" value="<?php echo htmlentities((app('request')->get('mobile') ?: '')); ?>" placeholder="请输入用户手机号"
                           class="layui-input"></div></div><div class="layui-form-item layui-inline"><label class="layui-form-label">发起时间</label><div class="layui-input-inline"><input data-date-range name="addtime" value="<?php echo htmlentities((app('request')->get('addtime') ?: '')); ?>" placeholder="请选择发起时间"
                           class="layui-input"></div></div><div class="layui-form-item layui-inline"><button class="layui-btn layui-btn-primary"><i class="layui-icon">&#xe615;</i> 搜 索</button><?php if(auth("daochu")): ?><a href="<?php echo url('daochu'); ?>" class="layui-btn layui-btn-danger"><i class="layui-icon">&#xe615;</i>
                    导 出</a><?php endif; ?></div></form></fieldset><fieldset><legend>数据小记</legend><div class="layui-form-item layui-inline">
            第三方累计提现：<?php echo config("currency"); ?><?php echo htmlentities($total_num); ?>，第三方手续费：<?php echo config("currency"); ?><?php echo !empty($total_fee) ? htmlentities($total_fee) : 0; ?>，第三方成功收款：<?php echo config("currency"); ?><?php echo !empty($success_num) ? htmlentities($success_num) : 0; ?>，第三方提现成功人数：<?php echo htmlentities($success_cnt); ?></div></fieldset><!--<fieldset>当前付款方式：<?php echo htmlentities($payout_type); ?></fieldset>--><script>form.render()</script><table class="layui-table margin-top-15" lay-skin="line"><?php if(!(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty()))): ?><thead><tr><th class='list-table-check-td think-checkbox'><input data-auto-none data-check-target='.list-check-box' type='checkbox'></th><th class='text-left nowrap' title="订单号/提现方式/代理">订单号/提现方式/代理</th><th class='text-left nowrap' title="用户/手机/级别/余额">用户信息</th><th class='text-left nowrap' title="用户/手机/级别/余额">一级代理/二级代理</th><th class='text-left nowrap' title="提现金额/手续费/实际到账">提现金额/手续费</th><th class='text-left nowrap' title="银行名称/开户名称/卡号/分行号/类型">银行信息/usdt</th><!--            <th class='text-left nowrap'>电子钱包</th>--><th class='text-left nowrap'>发起/处理/回调</th><th class='text-left nowrap'>审核状态</th><th class='text-left nowrap'>代理审核</th><th class='text-left nowrap'>三方状态</th><th class='text-left nowrap'>凭证</th><?php if(auth('do_deposit')): ?><th class='text-left nowrap'>操作</th><?php endif; ?></tr></thead><?php endif; ?><tbody><?php foreach($list as $key=>$vo): ?><tr><td class='list-table-check-td think-checkbox'><input class="list-check-box" value='<?php echo htmlentities($vo['id']); ?>' type='checkbox'></td><td class='text-left nowrap'><?php echo htmlentities($vo['id']); ?><br><?php echo htmlentities($vo['w_type']); ?><br></td><td class='text-left nowrap'><?php echo htmlentities($vo['username']); if($vo['remark']): ?><span style="color:#f00">（<?php echo htmlentities($vo['remark']); ?>）</span><?php endif; ?><br><?php echo htmlentities($vo['u_tel']); ?><br>
                VIP<?php echo htmlentities($vo['level']); ?><br><?php echo config("currency"); ?><?php echo htmlentities($vo['balance']); ?></td><td><?php echo htmlentities((isset($agent_list[$vo['agent_id']]) && ($agent_list[$vo['agent_id']] !== '')?$agent_list[$vo['agent_id']]:'---')); ?><br><?php echo htmlentities((isset($agent_service_list[$vo['agent_service_id']]) && ($agent_service_list[$vo['agent_service_id']] !== '')?$agent_service_list[$vo['agent_service_id']]:'---')); ?></td><td class='text-left nowrap'><?php echo config("currency"); ?><?php echo htmlentities($vo['real_num']); if($vo['w_type']=='USDT'): ?>(U: <?php echo htmlentities($vo['num2']); ?>)<?php endif; ?><br><?php echo config("currency"); ?><?php echo htmlentities($vo['num'] - $vo['real_num']); ?> (<?php echo htmlentities($vo['shouxu']*100); ?>%)
                
            </td><td class='text-left nowrap'><?php if($vo['w_type']=='USDT'): ?><?php echo htmlentities($vo['usdt']); else: ?><?php echo htmlentities($vo['bankname']); ?><br><?php echo htmlentities($vo['khname']); ?><br><?php echo htmlentities($vo['cardnum']); ?><br><!-- -<?php echo htmlentities($vo['account_digit']); ?><br><?php echo htmlentities($vo['bank_branch']); ?><br><?php echo htmlentities($vo['bank_type']); ?><br>--><?php echo htmlentities($vo['document_type']); ?>&nbsp;&nbsp;<?php echo htmlentities($vo['document_id']); ?><?php endif; ?></td><!--<td class='text-left nowrap'><?php echo htmlentities($vo['tel']); ?><br><?php echo htmlentities($vo['wallet_document_type']); ?>&nbsp;&nbsp;<?php echo htmlentities($vo['wallet_document_id']); ?><br><?php echo htmlentities($vo['wallet_tel']); ?></td>--><td class='text-left nowrap'><?php echo htmlentities(format_datetime($vo['addtime'])); ?><br><?php echo htmlentities((format_datetime($vo['endtime']) ?: "-")); ?><br><?php echo htmlentities((format_datetime($vo['payout_time']) ?: "-")); ?></td><td class='text-left nowrap'><?php switch($vo['status']): case "1": ?>待审核<?php break; case "2": ?><a class="layui-btn layui-btn-xs">审核通过</a><?php break; case "3": ?><a class="layui-btn layui-btn-xs layui-btn-danger">审核驳回</a><?php break; case "4": ?>转账失败<?php break; ?><?php endswitch; ?></td><td class='text-left nowrap'><?php switch($vo['agent_status']): case "1": ?>待审核<?php break; case "2": ?><a class="layui-btn layui-btn-xs">审核通过</a><?php break; case "3": ?><a class="layui-btn layui-btn-xs layui-btn-danger">审核驳回</a><?php break; case "4": ?>转账失败<?php break; ?><?php endswitch; ?></td><td class='text-left'><?php switch($vo['payout_status']): case "0": ?>未提交<?php break; case "1": ?><a class="layui-btn layui-btn-xs layui-btn-primary">已提交</a><?php break; case "2": ?><a class="layui-btn layui-btn-xs">转账成功</a><?php break; case "3": ?><a class="layui-btn layui-btn-xs layui-btn-danger">转账失败</a><?php break; ?><?php endswitch; ?><br><?php echo htmlentities($vo['payout_err_msg']); ?></td><td class='text-left nowrap'><?php if($vo['voucher']): ?><a href="<?php echo htmlentities($vo['voucher']); ?>" target="_blank" title="点击查看大图"><img src="<?php echo htmlentities($vo['voucher']); ?>" style="max-width:80px;max-height:80px;border:1px solid #eee;padding:2px;background:#fff;cursor:pointer;"></a><?php endif; ?></td><td class='text-left nowrap'><?php if(($vo['status'] == 1) and auth("do_deposit")): if($agent_id>0 && $vo['agent_status']>1): else: ?><a class="layui-btn layui-btn-xs deposit_apply"
                       data-confirm="确定通过此提现记录吗?"
                       data-csrf="<?php echo systoken('do_deposit'); ?>"
                       data-action="<?php echo url('do_deposit'); ?>"
                       data-value="id#<?php echo htmlentities($vo['id']); ?>;status#2">通过</a><a class="layui-btn layui-btn-xs layui-btn-warm"
                       data-prompt="请输入驳回内容"
                       data-csrf="<?php echo systoken('do_deposit'); ?>"
                       data-action="<?php echo url('do_deposit'); ?>"
                       data-value="id#<?php echo htmlentities($vo['id']); ?>;status#3;uid#<?php echo htmlentities($vo['uid']); ?>;num#<?php echo htmlentities($vo['num']); ?>">驳回</a><?php if($agent_id==0): ?><!-- <a class="layui-btn layui-btn-xs layui-btn-danger deposit_demo_apply"
                       data-confirm="确定假设通过吗?此操作不会提交到第三方"
                       data-csrf="<?php echo systoken('do_deposit'); ?>"
                       data-action="<?php echo url('do_deposit'); ?>"
                       data-value="id#<?php echo htmlentities($vo['id']); ?>;status#88">假通过</a> --><?php endif; ?><?php endif; ?><?php endif; ?><a data-dbclick class="layui-btn layui-btn-xs layui-btn-primary" data-title="用户备注"
                   data-modal='<?php echo url("deal/edit_deposit_remark"); ?>?id=<?php echo htmlentities($vo['id']); ?>'>备注</a><a data-dbclick class="layui-btn layui-btn-xs layui-btn-warm" data-title="上传凭证"
                   data-modal='<?php echo url("deal/upload_voucher"); ?>?id=<?php echo htmlentities($vo['id']); ?>'><?php if($vo['voucher']): ?>查看凭证<?php else: ?>上传凭证<?php endif; ?></a><!--<?php if($vo['status']>1): ?><?php echo htmlentities($vo['payout_type']); ?><?php endif; ?>--></td></tr><?php endforeach; ?></tbody></table><?php if(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty())): ?><span class="notdata">没有记录哦</span><?php else: ?><?php echo (isset($pagehtml) && ($pagehtml !== '')?$pagehtml:''); ?><?php endif; ?><script>
        var payType = '<?php echo htmlentities($payout_type); ?>';
        $('.deposit_apply').click(function () {
            var data = {
                "id": $(this).attr('data-id'),
                "status": 2,
                "payout_type": payType,
                "_csrf_": $(this).attr('data-csrf'),
            };
            layer.confirm('确定对该比订单付款吗？', {
                btn: [payType, '取消'], //可以无限个按钮
            }, function (index, layero) {
                depositListApply(data);
            }, function (index) {
                depositListApply(data);
            });
        });

        function depositListApply(data) {
            var lIndex = layer.load(2);
            $.ajax({
                type: 'POST',
                url: "<?php echo url('do_deposit'); ?>",
                data: data,
                success: function (res) {
                    layer.close(lIndex);
                    layer.alert(res.info, function (index) {
                        if (res.code == 1) location.reload();
                        layer.close(index);
                    });
                }
            });
        }
    </script></div></div></div><script>
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
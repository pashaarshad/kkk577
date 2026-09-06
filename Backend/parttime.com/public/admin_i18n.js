/**
 * Global Admin Internationalization (i18n) Engine
 * Seamless Chinese <-> English toggle for all menus, headers, buttons, tables, forms, and dialogs.
 */
(function (window, document) {
    'use strict';

    var dict = [
        // Navigation Sectors
        { zh: '系统管理', en: 'System Management' },
        { zh: '会员管理', en: 'Member Management' },
        { zh: '财务管理', en: 'Billing Management' },
        { zh: '活动管理', en: 'Activity Management' },
        { zh: '应用管理', en: 'App Management' },
        { zh: '运营管理', en: 'Operations Management' },
        { zh: '商品管理', en: 'Product Management' },
        { zh: '订单管理', en: 'Order Management' },
        { zh: '数据统计', en: 'Data Statistics' },

        { zh: '提现待审(', en: 'Pending (' },
        { zh: '未处理提款', en: 'Pending Withdrawals' },
        { zh: '续费', en: 'Renewal' },
        { zh: '公告', en: 'Notice' },
        { zh: '清缓存', en: 'Clear Cache' },
        { zh: '注销登录', en: 'Logout' },
        { zh: '注销', en: 'Logout' },
        { zh: '基本资料', en: 'Personal Info' },
        { zh: '个人资料', en: 'Profile' },
        { zh: '个人中心', en: 'User Center' },

        // Menus & Submodules
        { zh: '系统配置', en: 'System Configuration' },
        { zh: '基础设置', en: 'Basic Settings' },
        { zh: '基本功能', en: 'Basic Features' },
        { zh: '管理员管理', en: 'Administrators' },
        { zh: '角色管理', en: 'Role Management' },
        { zh: '权限管理', en: 'Permissions' },
        { zh: '会员列表', en: 'Member List' },
        { zh: '会员等级', en: 'VIP Levels' },
        { zh: '代理管理', en: 'Agent Management' },
        { zh: '会员充值', en: 'Member Recharge' },
        { zh: '会员提现', en: 'Member Withdrawal' },
        { zh: '会员日志', en: 'Member Logs' },
        { zh: '会员详情', en: 'Member Details' },
        { zh: '充值订单', en: 'Recharge Orders' },
        { zh: '提款订单', en: 'Withdrawal Orders' },
        { zh: '提现订单', en: 'Withdrawal Orders' },
        { zh: '资金明细', en: 'Financial Records' },
        { zh: '资金流水', en: 'Fund Flows' },
        { zh: '银行卡管理', en: 'Bank Cards' },
        { zh: '收付款通道', en: 'Payment Channels' },
        { zh: '充提币种', en: 'Crypto Currencies' },
        { zh: '内容设置', en: 'Content Settings' },
        { zh: '公司简介', en: 'Company Profile' },
        { zh: '轮播图设置', en: 'Banner Settings' },
        { zh: '轮播图管理', en: 'Banner Management' },
        { zh: '监管机构', en: 'Regulatory Agency' },
        { zh: '用户协议', en: 'User Agreement' },
        { zh: '隐私政策', en: 'Privacy Policy' },
        { zh: '首页视频管理', en: 'Home Video Management' },
        { zh: '首页视频', en: 'Home Videos' },
        { zh: '营销配置', en: 'Marketing Configuration' },
        { zh: '推广设置', en: 'Promotion Settings' },
        { zh: '公告管理', en: 'Announcement Management' },
        { zh: '理财产品', en: 'Financial Products' },
        { zh: '理财订单', en: 'Financial Orders' },
        { zh: '投资管理', en: 'Investment Management' },
        { zh: '任务管理', en: 'Task Management' },
        { zh: '语言管理', en: 'Language Management' },
        { zh: '语言设置', en: 'Language Settings' },
        { zh: '短信配置', en: 'SMS Configuration' },
        { zh: '邮件配置', en: 'Email Configuration' },
        { zh: '存储配置', en: 'Storage Configuration' },
        { zh: '字典管理', en: 'Dictionary Management' },
        { zh: '附件管理', en: 'Attachment Management' },
        { zh: '操作日志', en: 'Operation Logs' },
        { zh: '登录日志', en: 'Login Logs' },
        { zh: '系统日志', en: 'System Logs' },
        { zh: '账单管理', en: 'Billing Management' },

        // System Config specifics
        { zh: '面板语言', en: 'Panel Language' },
        { zh: '皮肤模板', en: 'Skin Template' },
        { zh: '皮肤样式', en: 'Skin Style' },
        { zh: '当前默认皮肤', en: 'Default Theme' },
        { zh: '默认样式', en: 'Default Style' },
        { zh: '暂无其他皮肤', en: 'No skin available' },
        { zh: '暂无其他样式', en: 'No style available' },
        { zh: '平台名称', en: 'Platform Name' },
        { zh: '网站名称', en: 'Site Name' },
        { zh: '系统版本', en: 'System Version' },
        { zh: '版权信息', en: 'Copyright Info' },
        { zh: '网站图标', en: 'Site Icon' },
        { zh: '客服链接', en: 'Support Link' },
        { zh: '登录页背景图', en: 'Login Background' },
        { zh: '我的页背景图', en: 'Profile Background' },
        { zh: '安全设置', en: 'Security Settings' },
        { zh: '注册设置', en: 'Registration Settings' },
        { zh: '提现设置', en: 'Withdrawal Settings' },
        { zh: '充值设置', en: 'Recharge Settings' },
        { zh: '客服设置', en: 'Customer Support' },
        { zh: '关于我们', en: 'About Us' },
        { zh: '最小充值金额', en: 'Min Recharge Amount' },
        { zh: '最大充值金额', en: 'Max Recharge Amount' },
        { zh: '最小提现金额', en: 'Min Withdrawal Amount' },
        { zh: '最大提现金额', en: 'Max Withdrawal Amount' },
        { zh: '提现手续费', en: 'Withdrawal Fee' },
        { zh: '每日提现次数', en: 'Daily Withdrawal Limit' },
        { zh: '提现时间段', en: 'Withdrawal Hours' },
        { zh: '谷歌验证器', en: 'Google Authenticator' },
        { zh: '资金密码', en: 'Fund Password' },
        { zh: '佣金转本金', en: 'Commission to Principal' },
        { zh: '注册赠送体验金', en: 'Registration Bonus' },
        { zh: '体验金过期时间', en: 'Bonus Expiration Time' },

        // Compound Buttons & Toolbar Actions (from screenshot)
        { zh: '一键审核', en: 'Batch Audit' },
        { zh: '一键出款', en: 'Batch Payout' },
        { zh: '手动出款', en: 'Manual Payout' },
        { zh: '一键退回', en: 'Batch Return' },
        { zh: '导出订单', en: 'Export Orders' },
        { zh: '批量删除', en: 'Batch Delete' },
        { zh: '保存设置', en: 'Save Settings' },
        { zh: '确认到账', en: 'Confirm Received' },
        { zh: '审核通过', en: 'Audit Pass' },
        { zh: '审核拒绝', en: 'Audit Reject' },
        { zh: '审核驳回', en: 'Audit Reject' },
        { zh: '原路退款', en: 'Refund' },
        { zh: '同意', en: 'Approve' },
        { zh: '通过', en: 'Approve' },
        { zh: '驳回', en: 'Reject' },
        { zh: '拒绝', en: 'Reject' },
        { zh: '退款', en: 'Refund' },
        { zh: '退回', en: 'Return' },
        { zh: '重试', en: 'Retry' },
        { zh: '查询', en: 'Search' },
        { zh: '搜索', en: 'Search' },
        { zh: '重置', en: 'Reset' },
        { zh: '新增', en: 'Add' },
        { zh: '添加', en: 'Add' },
        { zh: '创建', en: 'Create' },
        { zh: '编辑', en: 'Edit' },
        { zh: '修改', en: 'Edit' },
        { zh: '删除', en: 'Delete' },
        { zh: '保存', en: 'Save' },
        { zh: '提交', en: 'Submit' },
        { zh: '确定', en: 'Confirm' },
        { zh: '确认', en: 'Confirm' },
        { zh: '取消', en: 'Cancel' },
        { zh: '关闭', en: 'Close' },
        { zh: '查看', en: 'View' },
        { zh: '详情', en: 'Details' },
        { zh: '上传图片', en: 'Upload Image' },
        { zh: '选择图片', en: 'Choose Image' },
        { zh: '选择附件', en: 'Choose File' },
        { zh: '删除图片', en: 'Remove Image' },
        { zh: '上传', en: 'Upload' },
        { zh: '刷新', en: 'Refresh' },
        { zh: '导出', en: 'Export' },
        { zh: '导入', en: 'Import' },
        { zh: '操作', en: 'Actions' },
        { zh: '预览皮肤', en: 'Preview Skin' },
        { zh: '展开', en: 'Expand' },
        { zh: '收起', en: 'Collapse' },
        { zh: '修改余额', en: 'Adjust Balance' },
        { zh: '人工充值', en: 'Manual Recharge' },
        { zh: '重置密码', en: 'Reset Password' },
        { zh: '修改密码', en: 'Change Password' },

        // Table Headers & Search Labels (from screenshot)
        { zh: '用户信息', en: 'User Info' },
        { zh: '订单信息', en: 'Order Info' },
        { zh: '提现信息', en: 'Withdrawal Info' },
        { zh: '审核状态', en: 'Audit Status' },
        { zh: '出款信息', en: 'Payout Info' },
        { zh: '转账结果', en: 'Transfer Result' },
        { zh: '提现金额', en: 'Withdrawal Amount' },
        { zh: '出款地址', en: 'Payout Address' },
        { zh: '提现地址', en: 'Withdrawal Address' },
        { zh: '转账状态', en: 'Transfer Status' },
        { zh: '出款类型', en: 'Payout Type' },
        { zh: '提现类型', en: 'Withdrawal Type' },
        { zh: '申请时间', en: 'Applied Time' },
        { zh: '操作时间', en: 'Action Time' },
        { zh: '审核时间', en: 'Audit Time' },
        { zh: '打款状态', en: 'Payout Status' },
        { zh: '出款金额', en: 'Payout Amount' },
        { zh: '平台单号', en: 'Platform Order No.' },
        { zh: '顶级上级', en: 'Top Referrer' },
        { zh: '一级上级', en: 'Direct Referrer' },
        { zh: '到账类型', en: 'Arrival Type' },
        { zh: '24小时到账(1天)', en: 'Within 24h (1 Day)' },
        { zh: '48小时到账(2天)', en: 'Within 48h (2 Days)' },
        { zh: '72小时到账(3天)', en: 'Within 72h (3 Days)' },
        { zh: '96小时到账(4天)', en: 'Within 96h (4 Days)' },
        { zh: '120小时到账(5天)', en: 'Within 120h (5 Days)' },
        { zh: '144小时到账(6天)', en: 'Within 144h (6 Days)' },
        { zh: '168小时到账(7天)', en: 'Within 168h (7 Days)' },
        { zh: '24小时到账', en: 'Within 24 Hours' },
        { zh: '立即到账', en: 'Instant Arrival' },
        { zh: '小时到账', en: 'Hours Arrival' },
        { zh: '最近充值', en: 'Recent Recharge' },
        { zh: '实际到账', en: 'Received Amount' },
        { zh: '提款账户', en: 'Withdrawal Account' },
        { zh: '收款人账户', en: 'Payee Account' },
        { zh: '收款人姓名', en: 'Payee Name' },
        { zh: '开户银行', en: 'Bank Name' },
        { zh: '用户姓名', en: 'User Name' },
        { zh: '账户类型', en: 'Account Type' },
        { zh: '证件号码', en: 'ID Number' },
        { zh: 'PIX类型', en: 'PIX Type' },
        { zh: 'PIX税号', en: 'PIX Tax ID' },
        { zh: 'CPF号', en: 'CPF Number' },
        { zh: '开户名', en: 'Account Name' },
        { zh: '提款IP', en: 'Withdrawal IP' },
        { zh: '提数IP', en: 'Withdrawal IP' },
        { zh: '用户IP', en: 'User IP' },
        { zh: '打款tx', en: 'Payout TXID' },
        { zh: '打款TX', en: 'Payout TXID' },
        { zh: '手续费', en: 'Fee' },
        { zh: '税费', en: 'Tax Fee' },
        { zh: '订单号', en: 'Order No.' },
        { zh: '操作员', en: 'Operator' },
        { zh: '审核员', en: 'Auditor' },
        { zh: '用户ID', en: 'User ID' },
        { zh: '会员ID', en: 'Member ID' },
        { zh: '用户名', en: 'Username' },
        { zh: '用户账号', en: 'User Account' },
        { zh: '会员账号', en: 'Account' },
        { zh: '真实姓名', en: 'Real Name' },
        { zh: '手机号', en: 'Mobile' },
        { zh: '手机号码', en: 'Phone Number' },
        { zh: '邮箱', en: 'Email' },
        { zh: '邀请码', en: 'Invite Code' },
        { zh: '推荐人', en: 'Referrer' },
        { zh: '上级代理', en: 'Superior Agent' },
        { zh: '账户余额', en: 'Balance' },
        { zh: '可用余额', en: 'Available Balance' },
        { zh: '冻结金额', en: 'Frozen Amount' },
        { zh: '佣金余额', en: 'Commission Balance' },
        { zh: '累计充值', en: 'Total Recharge' },
        { zh: '累计提现', en: 'Total Withdrawal' },
        { zh: '团队人数', en: 'Team Size' },
        { zh: '直推人数', en: 'Direct Referrals' },
        { zh: '交易号', en: 'Transaction ID' },
        { zh: '充值金额', en: 'Recharge Amount' },
        { zh: '提款金额', en: 'Withdrawal Amount' },
        { zh: '实际金额', en: 'Actual Amount' },
        { zh: '到账金额', en: 'Received Amount' },
        { zh: '充值方式', en: 'Recharge Method' },
        { zh: '支付方式', en: 'Payment Method' },
        { zh: '充值类型', en: 'Recharge Type' },
        { zh: '充值凭证', en: 'Voucher' },
        { zh: '支付凭证', en: 'Voucher' },
        { zh: '凭证', en: 'Voucher' },
        { zh: '开户行', en: 'Bank Name' },
        { zh: '银行名称', en: 'Bank Name' },
        { zh: '银行卡号', en: 'Card Number' },
        { zh: '收款人', en: 'Payee Name' },
        { zh: '开户姓名', en: 'Account Name' },
        { zh: '钱包地址', en: 'Wallet Address' },
        { zh: '网络协议', en: 'Protocol / Chain' },
        { zh: '链路类型', en: 'Chain Type' },
        { zh: '操作人', en: 'Operator' },
        { zh: '审核人员', en: 'Auditor' },
        { zh: '发送地址', en: 'Sender Address' },
        { zh: '接收地址', en: 'Receiver Address' },
        { zh: '管理员备注', en: 'Admin Remarks' },
        { zh: '备注信息', en: 'Remarks Info' },
        { zh: '备注', en: 'Remarks' },
        { zh: '说明', en: 'Description' },
        { zh: '类型', en: 'Type' },
        { zh: '排序', en: 'Sort Order' },
        { zh: '权重', en: 'Weight' },
        { zh: '图标', en: 'Icon' },
        { zh: '标题', en: 'Title' },
        { zh: '名称', en: 'Name' },
        { zh: '地址', en: 'Address' },
        { zh: '内容', en: 'Content' },

        // Statuses
        { zh: '提现拒绝', en: 'Withdrawal Rejected' },
        { zh: '提现驳回', en: 'Withdrawal Rejected' },
        { zh: '提现成功', en: 'Withdrawal Succeeded' },
        { zh: '提现忽略', en: 'Withdrawal Ignored' },
        { zh: '转账成功', en: 'Transfer Succeeded' },
        { zh: '转账失败', en: 'Transfer Failed' },
        { zh: '余额不足', en: 'Insufficient Balance' },
        { zh: '待确认', en: 'Pending Confirmation' },
        { zh: '待审核', en: 'Pending' },
        { zh: '处理中', en: 'Processing' },
        { zh: '队列中', en: 'In Queue' },
        { zh: '审核中', en: 'Under Review' },
        { zh: '已通过', en: 'Approved' },
        { zh: '已拒绝', en: 'Rejected' },
        { zh: '已驳回', en: 'Rejected' },
        { zh: '已完成', en: 'Completed' },
        { zh: '已退款', en: 'Refunded' },
        { zh: '充值成功', en: 'Recharge Succeeded' },
        { zh: '充值失败', en: 'Recharge Failed' },
        { zh: '成功', en: 'Success' },
        { zh: '失败', en: 'Failed' },
        { zh: '正常', en: 'Normal' },
        { zh: '锁定', en: 'Locked' },
        { zh: '禁用', en: 'Disabled' },
        { zh: '启用', en: 'Enabled' },
        { zh: '开启', en: 'Enabled' },
        { zh: '关闭', en: 'Disabled' },
        { zh: '未支付', en: 'Unpaid' },
        { zh: '已支付', en: 'Paid' },
        { zh: '状态', en: 'Status' },
        { zh: '创建时间', en: 'Created Time' },
        { zh: '更新时间', en: 'Updated Time' },
        { zh: '处理时间', en: 'Processed Time' },
        { zh: '注册时间', en: 'Registered Time' },
        { zh: '最后登录时间', en: 'Last Login Time' },

        // Base Individual Words (Fallback to catch isolated Chinese words)
        { zh: '用户', en: 'User' },
        { zh: '代理', en: 'Agent' },
        { zh: '国家', en: 'Country' },
        { zh: '币种', en: 'Currency' },
        { zh: '审核', en: 'Audit' },
        { zh: '打款', en: 'Payout' },
        { zh: '出款', en: 'Payout' },
        { zh: '转账', en: 'Transfer' },
        { zh: '订单', en: 'Orders' },
        { zh: '手动', en: 'Manual' },
        { zh: '一键', en: 'Batch' },
        { zh: '到账', en: 'Arrival' },
        { zh: '信息', en: 'Info' },
        { zh: '结果', en: 'Result' },
        { zh: '金额', en: 'Amount' },
        { zh: '时间', en: 'Time' },
        { zh: '单号', en: 'No.' },
        { zh: '人员', en: 'Staff' },
        { zh: '首充', en: 'First Deposit' },
        { zh: '累充', en: 'Cumulative Deposit' },

        // Table Pagination & LayUI Components
        { zh: '10 条/页', en: '10 / page' },
        { zh: '20 条/页', en: '20 / page' },
        { zh: '30 条/页', en: '30 / page' },
        { zh: '50 条/页', en: '50 / page' },
        { zh: '90 条/页', en: '90 / page' },
        { zh: '条/页', en: '/ page' },
        { zh: '共 ', en: 'Total ' },
        { zh: ' 条', en: ' items' },
        { zh: '到第', en: 'Go to' },
        { zh: '页', en: 'Page' },
        { zh: '确定', en: 'Confirm' },
        { zh: '中文', en: 'ZH' },
        { zh: '英文', en: 'EN' },

        // Messages & Placeholders
        { zh: '操作成功', en: 'Operation succeeded' },
        { zh: '操作失败', en: 'Operation failed' },
        { zh: '暂无数据', en: 'No data available' },
        { zh: '数据加载中', en: 'Loading data...' },
        { zh: '请输入', en: 'Please enter ' },
        { zh: '请选择', en: 'Please select ' },
        { zh: '提示', en: 'Notice' },
        { zh: '警告', en: 'Warning' },
        { zh: '确认删除', en: 'Confirm Delete' }
    ];

    // Sort dictionary descending by Chinese phrase length to prevent sub-string collision
    dict.sort(function (a, b) {
        return b.zh.length - a.zh.length;
    });

    var I18N = {
        dict: dict,

        getLang: function () {
            try {
                return localStorage.getItem('admin_lang') || 'en';
            } catch (e) {
                return 'en';
            }
        },

        setLang: function (lang) {
            try {
                localStorage.setItem('admin_lang', lang);
                document.cookie = 'admin_lang=' + lang + '; path=/; max-age=31536000';
            } catch (e) {}

            I18N.applyLang(lang);

            // Notify all iframe children
            try {
                var frames = document.querySelectorAll('iframe');
                for (var i = 0; i < frames.length; i++) {
                    try {
                        var f = frames[i];
                        if (f.contentWindow && f.contentWindow.I18N) {
                            f.contentWindow.I18N.applyLang(lang);
                        } else if (f.contentWindow) {
                            f.contentWindow.postMessage({ type: 'ADMIN_I18N_SET_LANG', lang: lang }, '*');
                        }
                    } catch (err) {}
                }
            } catch (e) {}

            // Notify parent window if in an iframe
            try {
                if (window.parent && window.parent !== window) {
                    window.parent.postMessage({ type: 'ADMIN_I18N_SET_LANG', lang: lang }, '*');
                }
            } catch (e) {}
        },

        translateText: function (str, targetLang) {
            if (!str || typeof str !== 'string') return str;
            if (targetLang !== 'en') return str;

            var res = str;
            for (var i = 0; i < dict.length; i++) {
                var item = dict[i];
                if (res.indexOf(item.zh) !== -1) {
                    res = res.split(item.zh).join(item.en);
                }
            }
            // Replace Chinese full-width colon with English colon
            res = res.replace(/：/g, ': ');
            return res;
        },

        translateNode: function (node, targetLang) {
            if (!node) return;

            // 1. Text Node
            if (node.nodeType === Node.TEXT_NODE) {
                var val = node.nodeValue;
                if (!val || !val.trim()) return;

                if (node.__zh_orig === undefined) {
                    node.__zh_orig = val;
                }

                if (targetLang === 'en') {
                    node.nodeValue = I18N.translateText(node.__zh_orig, 'en');
                } else {
                    node.nodeValue = node.__zh_orig;
                }
                return;
            }

            // 2. Element Node
            if (node.nodeType === Node.ELEMENT_NODE) {
                var tag = node.tagName.toLowerCase();
                if (tag === 'script' || tag === 'style' || tag === 'svg' || tag === 'code') return;

                if (node.hasAttribute('placeholder')) {
                    if (node.__zh_placeholder === undefined) {
                        node.__zh_placeholder = node.getAttribute('placeholder');
                    }
                    node.setAttribute('placeholder', targetLang === 'en' ? I18N.translateText(node.__zh_placeholder, 'en') : node.__zh_placeholder);
                }

                if (node.hasAttribute('title')) {
                    if (node.__zh_title === undefined) {
                        node.__zh_title = node.getAttribute('title');
                    }
                    node.setAttribute('title', targetLang === 'en' ? I18N.translateText(node.__zh_title, 'en') : node.__zh_title);
                }

                if ((tag === 'input' || tag === 'button') && (node.type === 'button' || node.type === 'submit' || node.type === 'reset')) {
                    if (node.hasAttribute('value')) {
                        if (node.__zh_val === undefined) {
                            node.__zh_val = node.getAttribute('value');
                        }
                        node.setAttribute('value', targetLang === 'en' ? I18N.translateText(node.__zh_val, 'en') : node.__zh_val);
                    }
                }

                if (tag === 'option') {
                    if (node.__zh_text === undefined) {
                        node.__zh_text = node.text;
                    }
                    node.text = targetLang === 'en' ? I18N.translateText(node.__zh_text, 'en') : node.__zh_text;
                }

                var child = node.firstChild;
                while (child) {
                    I18N.translateNode(child, targetLang);
                    child = child.nextSibling;
                }
            }
        },

        applyLang: function (lang) {
            I18N.translateNode(document.body || document.documentElement, lang);

            // Update Dongle Switch UI in Header if present
            var track = document.getElementById('dongle-track');
            var slider = document.getElementById('dongle-slider');
            var txtZh = document.getElementById('dongle-text-zh');
            var txtEn = document.getElementById('dongle-text-en');

            if (track && slider && txtZh && txtEn) {
                if (lang === 'en') {
                    track.style.background = '#10b981';
                    slider.style.transform = 'translateX(14px)';
                    txtEn.style.color = '#ffffff';
                    txtZh.style.color = '#9ca3af';
                } else {
                    track.style.background = '#555c6d';
                    slider.style.transform = 'translateX(0px)';
                    txtZh.style.color = '#ffb800';
                    txtEn.style.color = '#9ca3af';
                }
            }

            // Update System Config Switch if present
            var chk = document.getElementById('admin_lang_checkbox');
            if (chk) {
                chk.checked = (lang === 'en');
                if (window.layui && window.layui.form) {
                    window.layui.form.render('checkbox');
                }
            }
        },

        init: function () {
            // Inject layout CSS fixes for sidebar width, text wrapping, table button overflow, and modal icons
            if (!document.getElementById('admin-i18n-css')) {
                var styleNode = document.createElement('style');
                styleNode.id = 'admin-i18n-css';
                styleNode.innerHTML =
                    '.layui-side, .pear-side, .layui-side-scroll, .pear-admin .layui-side { width: 235px !important; }\n' +
                    '.layui-body, .pear-body, .pear-container, .layui-layout-admin .layui-body { left: 235px !important; }\n' +
                    '.pear-nav-tree .layui-nav-item a, .layui-nav-tree .layui-nav-item a {\n' +
                    '    white-space: nowrap !important;\n' +
                    '    overflow: hidden !important;\n' +
                    '    text-overflow: ellipsis !important;\n' +
                    '    font-size: 13px !important;\n' +
                    '    padding-left: 14px !important;\n' +
                    '    padding-right: 8px !important;\n' +
                    '}\n' +
                    '.layui-layout-right .layui-nav-item > a {\n' +
                    '    padding: 0 10px !important;\n' +
                    '}\n' +
                    '.layui-layout-control {\n' +
                    '    left: 140px !important;\n' +
                    '    width: auto !important;\n' +
                    '    right: 480px !important;\n' +
                    '}\n' +
                    '.pear-nav-tree .layui-nav-child dd a, .layui-nav-tree .layui-nav-child dd a {\n' +
                    '    padding-left: 28px !important;\n' +
                    '}\n' +
                    '.layui-table-cell {\n' +
                    '    height: auto !important;\n' +
                    '    white-space: normal !important;\n' +
                    '    word-break: break-word !important;\n' +
                    '    overflow: visible !important;\n' +
                    '}\n' +
                    '.layui-btn-xs {\n' +
                    '    padding: 0 8px !important;\n' +
                    '}\n' +
                    '.layui-layer-setwin .layui-layer-close1 { background: none !important; text-decoration: none !important; font-size: 0 !important; }\n' +
                    '.layui-layer-setwin .layui-layer-close1:after { content: "✕" !important; font-family: sans-serif !important; font-size: 16px !important; font-weight: bold !important; color: #555 !important; display: block; line-height: 16px; text-align: center; }\n';    font-size: 12px !important;\n' +
                    '    height: 24px !important;\n' +
                    '    line-height: 24px !important;\n' +
                    '}\n';
                (document.head || document.documentElement).appendChild(styleNode);
            }

            var currentLang = I18N.getLang();

            I18N.applyLang(currentLang);

            // MutationObserver to automatically translate newly added DOM nodes
            if (window.MutationObserver && document.body) {
                var observer = new MutationObserver(function (mutations) {
                    var lang = I18N.getLang();
                    if (lang === 'en') {
                        for (var i = 0; i < mutations.length; i++) {
                            var mut = mutations[i];
                            if (mut.type === 'childList') {
                                for (var j = 0; j < mut.addedNodes.length; j++) {
                                    var node = mut.addedNodes[j];
                                    if (node.id === 'admin-lang-dongle') continue;
                                    I18N.translateNode(node, 'en');
                                }
                            }
                        }
                    }
                });
                observer.observe(document.body, { childList: true, subtree: true });
            }

            // Periodic 500ms safety scan for asynchronous tables, layui tooltips, popups
            setInterval(function () {
                if (I18N.getLang() === 'en' && document.body) {
                    I18N.translateNode(document.body, 'en');
                }
            }, 500);

            // Header Dongle Click Event Listener
            var dongle = document.getElementById('admin-lang-dongle');
            if (dongle) {
                dongle.onclick = function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var newLang = I18N.getLang() === 'en' ? 'zh' : 'en';
                    I18N.setLang(newLang);
                };
            }

            // Listen for cross-frame messages
            window.addEventListener('message', function (event) {
                if (event.data && event.data.type === 'ADMIN_I18N_SET_LANG') {
                    var targetLang = event.data.lang;
                    if (I18N.getLang() !== targetLang) {
                        try {
                            localStorage.setItem('admin_lang', targetLang);
                        } catch (e) {}
                    }
                    I18N.applyLang(targetLang);
                }
            });

            // Listen for storage events across tabs
            window.addEventListener('storage', function (e) {
                if (e.key === 'admin_lang' && e.newValue) {
                    I18N.applyLang(e.newValue);
                }
            });
        }
    };

    window.I18N = I18N;

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', I18N.init);
    } else {
        I18N.init();
    }

})(window, document);
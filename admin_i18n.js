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

        // Top Header
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

        // Buttons & Action Controls
        { zh: '批量删除', en: 'Batch Delete' },
        { zh: '保存设置', en: 'Save Settings' },
        { zh: '确认到账', en: 'Confirm Received' },
        { zh: '审核通过', en: 'Approve' },
        { zh: '审核拒绝', en: 'Reject' },
        { zh: '原路退款', en: 'Refund' },
        { zh: '同意', en: 'Approve' },
        { zh: '通过', en: 'Approve' },
        { zh: '驳回', en: 'Reject' },
        { zh: '拒绝', en: 'Reject' },
        { zh: '退款', en: 'Refund' },
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

        // Table Headers & Field Names
        { zh: '用户ID', en: 'User ID' },
        { zh: '会员ID', en: 'Member ID' },
        { zh: '用户名', en: 'Username' },
        { zh: '用户账号', en: 'User Account' },
        { zh: '会员账号', en: 'Account' },
        { zh: '真实姓名', en: 'Real Name' },
        { zh: '用户姓名', en: 'User Name' },
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
        { zh: '订单号', en: 'Order No.' },
        { zh: '交易号', en: 'Transaction ID' },
        { zh: '充值金额', en: 'Recharge Amount' },
        { zh: '提现金额', en: 'Withdrawal Amount' },
        { zh: '提款金额', en: 'Withdrawal Amount' },
        { zh: '实际金额', en: 'Actual Amount' },
        { zh: '实际到账', en: 'Received Amount' },
        { zh: '到账金额', en: 'Received Amount' },
        { zh: '手续费', en: 'Fee' },
        { zh: '充值方式', en: 'Recharge Method' },
        { zh: '支付方式', en: 'Payment Method' },
        { zh: '充值类型', en: 'Recharge Type' },
        { zh: '充值凭证', en: 'Voucher' },
        { zh: '支付凭证', en: 'Voucher' },
        { zh: '凭证', en: 'Voucher' },
        { zh: '开户银行', en: 'Bank Name' },
        { zh: '开户行', en: 'Bank Name' },
        { zh: '银行名称', en: 'Bank Name' },
        { zh: '银行卡号', en: 'Card Number' },
        { zh: '收款人', en: 'Payee Name' },
        { zh: '开户姓名', en: 'Account Name' },
        { zh: '钱包地址', en: 'Wallet Address' },
        { zh: '提现地址', en: 'Withdrawal Address' },
        { zh: '网络协议', en: 'Protocol / Chain' },
        { zh: '链路类型', en: 'Chain Type' },
        { zh: '操作人', en: 'Operator' },
        { zh: '审核人员', en: 'Auditor' },
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
        { zh: '待审核', en: 'Pending' },
        { zh: '审核中', en: 'Processing' },
        { zh: '未处理', en: 'Pending' },
        { zh: '已通过', en: 'Approved' },
        { zh: '已拒绝', en: 'Rejected' },
        { zh: '已驳回', en: 'Rejected' },
        { zh: '已完成', en: 'Completed' },
        { zh: '已退款', en: 'Refunded' },
        { zh: '充值成功', en: 'Recharge Succeeded' },
        { zh: '充值失败', en: 'Recharge Failed' },
        { zh: '提现成功', en: 'Withdrawal Succeeded' },
        { zh: '提现失败', en: 'Withdrawal Failed' },
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
        { zh: '申请时间', en: 'Applied Time' },
        { zh: '处理时间', en: 'Processed Time' },
        { zh: '审核时间', en: 'Audit Time' },
        { zh: '注册时间', en: 'Registered Time' },
        { zh: '最后登录时间', en: 'Last Login Time' },

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
                return localStorage.getItem('admin_lang') || 'zh';
            } catch (e) {
                return 'zh';
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
                    slider.style.transform = 'translateX(18px)';
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
            var currentLang = I18N.getLang();

            I18N.applyLang(currentLang);

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

            var dongle = document.getElementById('admin-lang-dongle');
            if (dongle) {
                dongle.onclick = function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var newLang = I18N.getLang() === 'en' ? 'zh' : 'en';
                    I18N.setLang(newLang);
                };
            }

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
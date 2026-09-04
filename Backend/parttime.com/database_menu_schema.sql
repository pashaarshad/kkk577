-- Rebuilt Clean System Menu Schema matching Reference Dashboard Architecture
-- Top Navigation: 3 Primary Categories (System Management, Membership Management, Billing Management)

TRUNCATE TABLE `system_menu`;

-- 1. Primary Top Navigation Categories (PID = 0)
INSERT INTO `system_menu` (`id`, `pid`, `title`, `icon`, `url`, `sort`, `status`) VALUES
(1001, 0, 'System Management (系统管理)', 'layui-icon layui-icon-set-fill', '#', 10, 1),
(1002, 0, 'Membership Management (会员管理)', 'layui-icon layui-icon-user', '#', 20, 1),
(1003, 0, 'Billing Management (账单管理)', 'layui-icon layui-icon-rmb', '#', 30, 1);

-- 2. Submenus under System Management (PID = 1001)
INSERT INTO `system_menu` (`id`, `pid`, `title`, `icon`, `url`, `sort`, `status`) VALUES
(101, 1001, 'Administrator Management (管理员管理)', 'layui-icon layui-icon-username', '/admin/user/index', 99, 1),
(102, 1001, 'Personal Information (个人资料)', 'layui-icon layui-icon-user', '/admin/index/info', 98, 1),
(103, 1001, 'System Configuration (系统配置)', 'layui-icon layui-icon-set-sm', '/admin/config/info', 97, 1),
(104, 1001, 'Deposit & Withdrawal Coins (充提币种)', 'layui-icon layui-icon-dollar', '/admin/pay/index', 96, 1),
(105, 1001, 'Content Settings (内容设置)', 'layui-icon layui-icon-template', '/admin/help/home_msg', 95, 1),
(106, 1001, 'Marketing Configuration (营销配置)', 'layui-icon layui-icon-diamond', '/admin/help/banner', 94, 1),
(107, 1001, 'Promotion Settings (推广设置)', 'layui-icon layui-icon-link', '/admin/help/message_ctrl', 93, 1),
(108, 1001, 'VIP Configuration (VIP配置)', 'layui-icon layui-icon-util', '/admin/users/level', 92, 1),
(109, 1001, 'Product Settings (商品设置)', 'layui-icon layui-icon-cart', '/admin/deal/goods_list', 91, 1),
(110, 1001, 'Language Settings (语言设置)', 'layui-icon layui-icon-app', '/admin/config/info', 90, 1),
(111, 1001, 'CF Settings (CF设置)', 'layui-icon layui-icon-auz', '/admin/config/info', 89, 1);

-- 3. Submenus under Membership Management (PID = 1002)
INSERT INTO `system_menu` (`id`, `pid`, `title`, `icon`, `url`, `sort`, `status`) VALUES
(201, 1002, 'Member List (会员列表)', 'layui-icon layui-icon-user', '/admin/users/index', 99, 1),
(202, 1002, 'Group Settings (分组设置)', 'layui-icon layui-icon-group', '/admin/group/index', 98, 1),
(203, 1002, 'Member Log (会员日志)', 'layui-icon layui-icon-template', '/admin/oplog/index', 97, 1),
(204, 1002, 'Member Transactions (会员流水)', 'layui-icon layui-icon-read', '/admin/deal/order_list', 96, 1),
(205, 1002, 'Internal Messages (站内信)', 'layui-icon layui-icon-dialogue', '/admin/help/message_ctrl', 95, 1),
(206, 1002, 'Telegram Info (电报信息)', 'layui-icon layui-icon-release', '/admin/users/cs_list', 94, 1),
(207, 1002, 'Balance Record (余额记录)', 'layui-icon layui-icon-read', '/admin/deal/deposit_list', 93, 1),
(208, 1002, 'Upgrade History (升级记录)', 'layui-icon layui-icon-file-b', '/admin/users/level', 92, 1),
(209, 1002, 'Share Review (分享审核)', 'layui-icon layui-icon-share', '/admin/help/home_msg', 91, 1),
(210, 1002, 'Test Account (测试账号)', 'layui-icon layui-icon-username', '/admin/users/index', 90, 1),
(211, 1002, 'Task Plan (任务计划)', 'layui-icon layui-icon-align-center', '/admin/deal/order_list', 89, 1),
(212, 1002, 'Fake Member Data (会员假数据)', 'layui-icon layui-icon-add-1', '/admin/users/index', 88, 1),
(213, 1002, 'Designated Winning (指定中奖)', 'layui-icon layui-icon-edit', '/admin/users/index', 87, 1),
(214, 1002, 'Automatic Pull-in Plan (自动拉入计划)', 'layui-icon layui-icon-set', '/admin/deal/order_list', 86, 1);

-- 4. Submenus under Billing Management (PID = 1003)
INSERT INTO `system_menu` (`id`, `pid`, `title`, `icon`, `url`, `sort`, `status`) VALUES
(301, 1003, 'Deposit Orders (充币订单)', 'layui-icon layui-icon-next', '/admin/deal/user_recharge', 99, 1),
(302, 1003, 'Withdrawal Orders (提币订单)', 'layui-icon layui-icon-prev', '/admin/deal/deposit_list', 98, 1),
(303, 1003, 'Lottery Records (抽奖记录)', 'layui-icon layui-icon-diamond', '/admin/deal/order_list', 97, 1),
(304, 1003, 'Collection Orders (归集订单)', 'layui-icon layui-icon-refresh-1', '/admin/deal/goods_list', 96, 1),
(305, 1003, 'Transfer Orders (转账订单)', 'layui-icon layui-icon-refresh', '/admin/deal/order_list', 95, 1),
(306, 1003, 'Task Log (任务记录)', 'layui-icon layui-icon-template', '/admin/deal/order_list', 94, 1),
(307, 1003, 'Task Center Records (任务中心记录)', 'layui-icon layui-icon-read', '/admin/deal/order_list', 93, 1),
(308, 1003, 'Payment Orders (支付订单)', 'layui-icon layui-icon-dollar', '/admin/pay/index', 92, 1);

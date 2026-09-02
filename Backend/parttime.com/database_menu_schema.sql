-- Clean System Menu SQL Schema
TRUNCATE TABLE `system_menu`;

INSERT INTO `system_menu` (`id`, `pid`, `title`, `icon`, `url`, `sort`, `status`) VALUES
(1001, 0, 'System Management', 'layui-icon layui-icon-set', '#', 1, 1),
(1002, 0, 'Membership Management', 'layui-icon layui-icon-user', '#', 2, 1),
(1003, 0, 'Billing Management', 'layui-icon layui-icon-rmb', '#', 3, 1),
(1004, 0, 'Report Management', 'layui-icon layui-icon-chart', '#', 4, 1),
(1005, 0, 'VIP Configuration', 'layui-icon layui-icon-diamond', '#', 5, 1),
(1006, 0, 'Deposit and Withdrawal Currencies', 'layui-icon layui-icon-pay', '#', 6, 1),
(1007, 0, 'System Settings', 'layui-icon layui-icon-component', '#', 7, 1),

(10, 1001, 'Administrator Management', 'layui-icon layui-icon-user', '/admin/user/index', 1, 1),
(11, 1001, 'Personal Information', 'layui-icon layui-icon-username', '/admin/index/info', 2, 1),
(12, 1001, 'System Configuration', 'layui-icon layui-icon-set-fill', '/admin/config/info', 3, 1),
(13, 1001, 'Deposit & Withdrawal Currencies', 'layui-icon layui-icon-pay', '/admin/pay/index', 4, 1),
(14, 1001, 'Content Settings', 'layui-icon layui-icon-file', '/admin/help/home_msg', 5, 1),
(15, 1001, 'Marketing Configuration', 'layui-icon layui-icon-flag', '/admin/help/banner', 6, 1),
(16, 1001, 'Promotion Settings', 'layui-icon layui-icon-share', '/admin/help/message_ctrl', 7, 1),
(17, 1001, 'VIP Configuration', 'layui-icon layui-icon-diamond', '/admin/users/level', 8, 1),
(18, 1001, 'Product Settings', 'layui-icon layui-icon-goods', '/admin/deal/goods_list', 9, 1),
(19, 1001, 'Language Settings', 'layui-icon layui-icon-engine', '/admin/config/info', 10, 1),
(103, 1001, 'Homepage Video Management', 'layui-icon layui-icon-video', '/admin/help/video', 11, 1),

(20, 1002, 'Member List', 'layui-icon layui-icon-group', '/admin/users/index', 1, 1),
(21, 1002, 'Group Settings', 'layui-icon layui-icon-tree', '/admin/group/index', 2, 1),
(22, 1002, 'Member Log', 'layui-icon layui-icon-list', '/admin/oplog/index', 3, 1),
(23, 1002, 'Member Transaction Records', 'layui-icon layui-icon-log', '/admin/deal/order_list', 4, 1),
(24, 1002, 'Internal Messages', 'layui-icon layui-icon-notice', '/admin/help/message_ctrl', 5, 1),
(25, 1002, 'Telegram Info', 'layui-icon layui-icon-dialogue', '/admin/users/cs_list', 6, 1),
(26, 1002, 'Balance Record', 'layui-icon layui-icon-dollar', '/admin/deal/deposit_list', 7, 1),
(27, 1002, 'Upgrade History', 'layui-icon layui-icon-upload-circle', '/admin/users/level', 8, 1),
(28, 1002, 'Share Review', 'layui-icon layui-icon-survey', '/admin/help/home_msg', 9, 1),
(29, 1002, 'Test Account', 'layui-icon layui-icon-vercode', '/admin/users/index', 10, 1),

(30, 1003, 'Deposit Orders', 'layui-icon layui-icon-add-circle', '/admin/deal/user_recharge', 1, 1),
(31, 1003, 'Withdrawal Orders', 'layui-icon layui-icon-reduce-circle', '/admin/deal/deposit_list', 2, 1),
(32, 1003, 'Lottery Records', 'layui-icon layui-icon-gift', '/admin/deal/order_list', 3, 1),
(33, 1003, 'Collection Orders', 'layui-icon layui-icon-cart-simple', '/admin/deal/goods_list', 4, 1),
(34, 1003, 'Transfer Orders', 'layui-icon layui-icon-transfer', '/admin/deal/order_list', 5, 1),
(35, 1003, 'Task Log', 'layui-icon layui-icon-form', '/admin/deal/order_list', 6, 1),
(36, 1003, 'Task Center Records', 'layui-icon layui-icon-table', '/admin/deal/order_list', 7, 1),
(37, 1003, 'Payment Orders', 'layui-icon layui-icon-pay', '/admin/pay/index', 8, 1),

(40, 1004, 'Dashboard Console', 'layui-icon layui-icon-home', '/admin/index/main', 1, 1),
(41, 1004, 'User Reports', 'layui-icon layui-icon-chart-screen', '/admin/users/index', 2, 1),
(42, 1004, 'Agent Reports', 'layui-icon layui-icon-user', '/admin/agent/index', 3, 1),
(43, 1004, 'Financial Ledger', 'layui-icon layui-icon-table', '/admin/deal/deposit_list', 4, 1),

(50, 1005, 'VIP Level Management', 'layui-icon layui-icon-diamond', '/admin/users/level', 1, 1),
(51, 1005, 'Add VIP Level', 'layui-icon layui-icon-add-1', '/admin/users/add_users_level', 2, 1),

(60, 1006, 'Payment Method Settings', 'layui-icon layui-icon-pay', '/admin/pay/index', 1, 1),
(61, 1006, 'Add Payment Method', 'layui-icon layui-icon-add-circle-fine', '/admin/pay/add', 2, 1),

(70, 1007, 'System Menu Management', 'layui-icon layui-icon-menu', '/admin/menu/index', 1, 1),
(71, 1007, 'Role Permission Control', 'layui-icon layui-icon-auth', '/admin/auth/index', 2, 1),
(72, 1007, 'Operation Logs', 'layui-icon layui-icon-list', '/admin/oplog/index', 3, 1),
(73, 1007, 'Queue Manager', 'layui-icon layui-icon-engine', '/admin/queue/index', 4, 1);

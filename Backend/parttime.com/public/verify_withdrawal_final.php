<?php
define('APP_PATH', __DIR__ . '/../application/');
require __DIR__ . '/../thinkphp/base.php';
$app = \think\Container::get('app');
$app->initialize();

\think\facade\Session::set('user_id', 3);
$_POST = [
    'num' => 111,
    'paypassword' => '123123',
    'address' => 'sdfdsagfadgadsfgasgasdfsa',
    'USDT_code' => 'sdfdsagfadgadsfgasgasdfsa',
    'type' => 'USDT',
    'method' => 'TRX'
];
$_SERVER['REQUEST_METHOD'] = 'POST';

$ctrl = new \app\index\controller\Ctrl($app);
$res = $ctrl->do_deposit();
echo "FINAL WITHDRAWAL RESULT: " . json_encode($res->getData()) . "\n";

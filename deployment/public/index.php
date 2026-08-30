<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 
// +----------------------------------------------------------------------
//技术 飞机 https://t.me/Teeeeemo
//后台地址 xxx.com/owe9j2/login
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | 

// +----------------------------------------------------------------------

namespace think;

$http = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] && $_SERVER['HTTPS'] != 'off') ? 'https' : 'http';
define('SITE_URL', $http . '://' . $_SERVER['HTTP_HOST']); // 网站域名
define('APP_PATH', __DIR__ . '/../application/');
// define('PHPEXCEL_ROOT', __DIR__ . '/../extend/PHPExcel/');

require __DIR__ . '/../thinkphp/base.php';
require __DIR__ . '/../extend/phpexcel/PHPExcel.php';
//require __DIR__ . '/../extend/org/Mobile.php';
//echo '<pre>';
//\think\facade\Config::set();
Container::get('app')->run()->send();




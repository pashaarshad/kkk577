<?php
namespace think;
define('APP_PATH', __DIR__ . '/../application/');
require __DIR__ . '/../thinkphp/base.php';
Container::get('app')->initialize();

use think\Db;

$user = Db::table('xy_users')->where('tel', '13312341234')->find();
$pwd_str = config('pwd_str');
echo "Pwd Str: {$pwd_str}\n";
echo "User Salt: {$user['salt']}\n";
echo "User Pwd Hash: {$user['pwd']}\n";

$passwords = ['123456', '123123', 'admin', '888888', '111111', '666666'];
foreach ($passwords as $p) {
    $hash = sha1($p . $user['salt'] . $pwd_str);
    echo "Testing '$p': $hash === {$user['pwd']} -> " . ($hash === $user['pwd'] ? "MATCH!" : "NO") . "\n";
}

// Reset password for 13312341234 to 123456 & 123123 for testing
$newPass = '123456';
$newHash = sha1($newPass . $user['salt'] . $pwd_str);
Db::table('xy_users')->where('tel', '13312341234')->update(['pwd' => $newHash]);
echo "\nUpdated 13312341234 password hash to match '123456'!\n";

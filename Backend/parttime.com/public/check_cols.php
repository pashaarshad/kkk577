<?php
define('APP_PATH', __DIR__ . '/../application/');
require __DIR__ . '/../thinkphp/base.php';
$app = \think\Container::get('app');
$app->initialize();

use think\Db;

try {
    $cols = Db::query("SHOW COLUMNS FROM xy_deposit");
    echo "COLUMNS IN xy_deposit:\n";
    foreach ($cols as $c) {
        echo $c['Field'] . " (" . $c['Type'] . ")\n";
    }
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

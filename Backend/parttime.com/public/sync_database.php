<?php
// Standalone Database Synchronization & Migration Script for VPS
// Run via CLI: php sync_database.php

define('APP_PATH', __DIR__ . '/../application/');
require __DIR__ . '/../thinkphp/base.php';
$app = \think\Container::get('app');
$app->initialize();

echo "=========================================================\n";
echo "   MIGRATING VPS DATABASE: SEEDING PAYMENT CHANNELS     \n";
echo "=========================================================\n\n";

use think\Db;

try {
    // 1. Disable legacy / outdated channels
    Db::name('xy_pay')->where('name', 'like', '%Qeapay%')->update(['status' => 0]);
    echo "✅ Disabled legacy test channels (Qeapay).\n";

    // 2. Define the 13 reference channels
    $referenceChannels = [
        ['name' => 'TRC20-USDT', 'name2' => 'TRC20', 'ico' => '/static/image/trc20-usdt.jpg', 'usercode' => 'TXYZo89h129kJs99aLqP10x992KmNsQW1a', 'min' => 1, 'max' => 100000, 'sort' => 100, 'status' => 1, 'is_payout' => 1],
        ['name' => 'TRX', 'name2' => 'TRX', 'ico' => '/static/image/trx.webp', 'usercode' => 'TXYZo89h129kJs99aLqP10x992KmNsQW1a', 'min' => 1, 'max' => 100000, 'sort' => 95, 'status' => 1, 'is_payout' => 1],
        ['name' => 'BEP20-USDT', 'name2' => 'BEP20', 'ico' => '/static/image/bep20-usdt.webp', 'usercode' => '0x4f85459F610376Ee6Ad77216785582c55817d5bc', 'min' => 1, 'max' => 100000, 'sort' => 90, 'status' => 1, 'is_payout' => 1],
        ['name' => 'BNB', 'name2' => 'BNB', 'ico' => '/static/image/bnb.webp', 'usercode' => '0x4f85459F610376Ee6Ad77216785582c55817d5bc', 'min' => 1, 'max' => 100000, 'sort' => 85, 'status' => 1, 'is_payout' => 1],
        ['name' => 'BEP20-USDC', 'name2' => 'BEP20', 'ico' => '/static/image/bep20-usdc.png', 'usercode' => '0x4f85459F610376Ee6Ad77216785582c55817d5bc', 'min' => 1, 'max' => 100000, 'sort' => 80, 'status' => 1, 'is_payout' => 1],
        ['name' => 'POLYGON-USDT', 'name2' => 'POLYGON', 'ico' => '/static/image/polygon-usdt.webp', 'usercode' => '0x4f85459F610376Ee6Ad77216785582c55817d5bc', 'min' => 1, 'max' => 100000, 'sort' => 75, 'status' => 1, 'is_payout' => 1],
        ['name' => 'ETH-USDT', 'name2' => 'ERC20', 'ico' => '/static/image/eth-usdt.webp', 'usercode' => '0x4f85459F610376Ee6Ad77216785582c55817d5bc', 'min' => 1, 'max' => 100000, 'sort' => 70, 'status' => 1, 'is_payout' => 1],
        ['name' => 'POLYGON-USDC', 'name2' => 'POLYGON', 'ico' => '/static/image/polygon-usdc.webp', 'usercode' => '0x4f85459F610376Ee6Ad77216785582c55817d5bc', 'min' => 1, 'max' => 100000, 'sort' => 65, 'status' => 1, 'is_payout' => 1],
        ['name' => 'ETH-USDC', 'name2' => 'ERC20', 'ico' => '/static/image/eth-usdc.webp', 'usercode' => '0x4f85459F610376Ee6Ad77216785582c55817d5bc', 'min' => 1, 'max' => 100000, 'sort' => 60, 'status' => 1, 'is_payout' => 1],
        ['name' => 'ETH', 'name2' => 'ETH', 'ico' => '/static/image/eth.webp', 'usercode' => '0x4f85459F610376Ee6Ad77216785582c55817d5bc', 'min' => 1, 'max' => 100000, 'sort' => 55, 'status' => 1, 'is_payout' => 1],
        ['name' => 'POLYGON', 'name2' => 'POLYGON', 'ico' => '/static/image/polygon.webp', 'usercode' => '0x4f85459F610376Ee6Ad77216785582c55817d5bc', 'min' => 1, 'max' => 100000, 'sort' => 50, 'status' => 1, 'is_payout' => 1],
        ['name' => 'ETH-PYUSD', 'name2' => 'ERC20', 'ico' => '/static/image/eth-pyusd.webp', 'usercode' => '0x4f85459F610376Ee6Ad77216785582c55817d5bc', 'min' => 1, 'max' => 100000, 'sort' => 45, 'status' => 1, 'is_payout' => 1],
        ['name' => 'PHP', 'name2' => 'PHP', 'ico' => '/static/image/flb.webp', 'usercode' => '09123456789', 'min' => 1, 'max' => 100000, 'sort' => 40, 'status' => 1, 'is_payout' => 1]
    ];

    foreach ($referenceChannels as $ch) {
        $existing = Db::name('xy_pay')->where('name', $ch['name'])->find();
        if ($existing) {
            Db::name('xy_pay')->where('id', $existing['id'])->update([
                'name2' => $ch['name2'],
                'ico' => $ch['ico'],
                'min' => $ch['min'],
                'max' => $ch['max'],
                'sort' => $ch['sort'],
                'status' => 1,
                'is_payout' => 1
            ]);
            echo "   [UPDATED] Channel: {$ch['name']}\n";
        } else {
            Db::name('xy_pay')->insert($ch);
            echo "   [INSERTED] Channel: {$ch['name']}\n";
        }
    }

    echo "\n=========================================================\n";
    echo "✅ ALL 13 REFERENCE PAYMENT CHANNELS SYNCED SUCCESSFULLY!\n";
    echo "=========================================================\n";
} catch (\Exception $e) {
    echo "❌ Migration Error: " . $e->getMessage() . "\n";
}

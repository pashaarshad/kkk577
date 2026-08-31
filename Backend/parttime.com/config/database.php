<?php

// +----------------------------------------------------------------------
// | ThinkAdmin Database Configuration (Auto-Detect Local vs VPS)
// +----------------------------------------------------------------------

// Check if running on Linux VPS or Windows Local
$is_vps = (PHP_OS_FAMILY === 'Linux') 
    || (isset($_SERVER['SERVER_ADDR']) && $_SERVER['SERVER_ADDR'] === '154.12.63.116')
    || (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], '154.12.63.116') !== false);

if ($is_vps) {
    // Linux VPS MySQL Configuration
    return [
        'debug'       => true,
        'type'        => 'mysql',
        'hostname'    => 'localhost',
        'database'    => 'kkk577',
        'username'    => 'kkk577user',
        'password'    => 'KKK5777.com',
        'charset'     => 'utf8mb4',
        'hostport'    => '3306',
        'deploy'      => 0,
        'rw_separate' => false,
    ];
} else {
    // Windows Local Development MySQL Configuration
    return [
        'debug'       => true,
        'type'        => 'mysql',
        'hostname'    => '127.0.0.1',
        'database'    => 'good',
        'username'    => 'root',
        'password'    => 'root',
        'charset'     => 'utf8mb4',
        'hostport'    => '3306',
        'deploy'      => 0,
        'rw_separate' => false,
    ];
}

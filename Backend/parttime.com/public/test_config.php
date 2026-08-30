<?php
// Define application path
define('APP_PATH', __DIR__ . '/../application/');
// Load think framework base
require __DIR__ . '/../thinkphp/base.php';

// Initialize App
\think\Container::get('app')->initialize();

// Get database config
$config = \think\Container::get('config')->get('database.');

echo "<h1>ThinkPHP Loaded Database Config:</h1>";
echo "<pre>";
print_r([
    'hostname' => $config['hostname'],
    'database' => $config['database'],
    'username' => $config['username'],
    'password' => $config['password'],
]);
echo "</pre>";

echo "<h1>Environment variables:</h1>";
echo "<pre>";
print_r([
    'ENV_DATABASE' => getenv('DATABASE'),
    'ENV_USERNAME' => getenv('USERNAME'),
    'ENV_PASSWORD' => getenv('PASSWORD'),
    'ENV_HOSTNAME' => getenv('HOSTNAME'),
]);
echo "</pre>";

echo "<h1>Checking .env file in root:</h1>";
$envPath = __DIR__ . '/../.env';
if (is_file($envPath)) {
    echo ".env file exists! Contents:\n";
    echo htmlspecialchars(file_get_contents($envPath));
} else {
    echo ".env file does not exist.\n";
}

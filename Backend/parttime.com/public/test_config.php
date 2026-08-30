<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Debugging Hostinger Database Config</h1>";

$configPath = __DIR__ . '/../config/database.php';
echo "Checking config/database.php path: " . htmlspecialchars($configPath) . "<br>";

if (is_file($configPath)) {
    echo "database.php file exists!<br>";
    $config = include $configPath;
    if (is_array($config)) {
        echo "Successfully loaded configuration array:<br>";
        echo "<pre>";
        print_r([
            'hostname' => isset($config['hostname']) ? $config['hostname'] : 'NOT SET',
            'database' => isset($config['database']) ? $config['database'] : 'NOT SET',
            'username' => isset($config['username']) ? $config['username'] : 'NOT SET',
            'password' => isset($config['password']) ? $config['password'] : 'NOT SET',
        ]);
        echo "</pre>";
    } else {
        echo "database.php did not return an array! Returned type: " . gettype($config) . "<br>";
    }
} else {
    echo "database.php file DOES NOT exist at that path!<br>";
}

echo "<h1>Checking .env file in root:</h1>";
$envPath = __DIR__ . '/../.env';
if (is_file($envPath)) {
    echo ".env file exists! Contents:<br><pre>";
    echo htmlspecialchars(file_get_contents($envPath));
    echo "</pre>";
} else {
    echo ".env file does not exist.<br>";
}

echo "<h1>Trying PDO Connection Test:</h1>";
if (isset($config) && is_array($config)) {
    try {
        $dsn = "mysql:host=" . $config['hostname'] . ";port=" . ($config['hostport'] ?? '3306') . ";dbname=" . $config['database'];
        echo "Testing connection to: " . htmlspecialchars($dsn) . " using username: " . htmlspecialchars($config['username']) . "<br>";
        $pdo = new PDO($dsn, $config['username'], $config['password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        echo "<b style='color:green;'>SUCCESS! Successfully connected to MySQL database.</b><br>";
    } catch (PDOException $e) {
        echo "<b style='color:red;'>CONNECTION FAILED: " . htmlspecialchars($e->getMessage()) . "</b><br>";
    }
}

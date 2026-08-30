<?php
$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
if (is_file($_SERVER["DOCUMENT_ROOT"] . $path)) {
    return false;
} else {
    require __DIR__ . "/index.php";
}

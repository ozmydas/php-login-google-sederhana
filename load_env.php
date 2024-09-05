<?php

declare(strict_types=1);

session_start();

require_once 'vendor/autoload.php';

// biar .env kebaca
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$CLIENT_ID = $_ENV['CLIENT_ID'];

// biar url ketulis otomatis
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    $WEB_URL = "https://";
else
    $WEB_URL = "http://";
 
$WEB_URL .= $_SERVER['HTTP_HOST'];

?>
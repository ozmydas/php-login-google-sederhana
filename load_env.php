<?php

declare(strict_types=1);

session_start();

require_once 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$CLIENT_ID = $_ENV['CLIENT_ID'];

if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    $WEB_URL = "https://";
else
    $WEB_URL = "http://";
// Append the host(domain name, ip) to the URL.   
$WEB_URL .= $_SERVER['HTTP_HOST'];

?>
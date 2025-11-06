<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'db-veterinaria.cwxvklhw4ski.us-east-1.rds.amazonaws.com';
$user = 'admin';
$pass = 'inacap2025';
$db   = 'db-veterinaria';
$port = 3306;
$ca   = 'C:\\xampp\\certs\\us-east-1-bundle.pem';

$mysqli = mysqli_init();
if ($mysqli === false) {
    fwrite(STDERR, "mysqli_init failed\n");
    exit(1);
}

// Prefer utf8mb4 to avoid MySQL 8.0 charset 255 handshake issues
if (defined('MYSQLI_SET_CHARSET_NAME')) {
    mysqli_options($mysqli, MYSQLI_SET_CHARSET_NAME, 'utf8mb4');
}
if (defined('MYSQLI_INIT_COMMAND')) {
    mysqli_options($mysqli, MYSQLI_INIT_COMMAND, 'SET NAMES utf8mb4');
}

// Set SSL CA
if (!mysqli_ssl_set($mysqli, null, null, $ca, null, null)) {
    fwrite(STDERR, "mysqli_ssl_set failed\n");
}

// If available in this PHP build, request server cert verification
if (defined('MYSQLI_OPT_SSL_VERIFY_SERVER_CERT')) {
    mysqli_options($mysqli, MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, true);
}

// Connect with SSL flag
if (!mysqli_real_connect($mysqli, $host, $user, $pass, null, $port, null, MYSQLI_CLIENT_SSL)) {
    fwrite(STDERR, "Connect error (" . mysqli_connect_errno() . "): " . mysqli_connect_error() . "\n");
    exit(1);
}

echo "Connected: " . mysqli_get_host_info($mysqli) . "\n";

// List databases
$result = mysqli_query($mysqli, 'SHOW DATABASES;');
if ($result === false) {
    fwrite(STDERR, "Query error (" . mysqli_errno($mysqli) . "): " . mysqli_error($mysqli) . "\n");
    exit(1);
}

while ($row = mysqli_fetch_row($result)) {
    echo $row[0] . "\n";
}

mysqli_free_result($result);
mysqli_close($mysqli);
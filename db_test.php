<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'veterinaria-vcms-instance-1.clvlgblzviug.us-east-1.rds.amazonaws.com';
// Allow override via query params for quick diagnostics: ?user=admin&pass=...
$user = isset($_GET['user']) ? $_GET['user'] : 'ci_user';
$pass = isset($_GET['pass']) ? $_GET['pass'] : 'veterinaria_vcms';
$db   = 'veterinaria_VCMS';
$port = 3306;
$ca   = null; // No SSL CA for local MySQL

$mysqli = mysqli_init();
if ($mysqli === false) {
    error_log("mysqli_init failed");
    echo "mysqli_init failed";
    exit(1);
}

// Prefer utf8mb4 to avoid MySQL 8.0 charset 255 handshake issues
if (defined('MYSQLI_SET_CHARSET_NAME')) {
    mysqli_options($mysqli, MYSQLI_SET_CHARSET_NAME, 'utf8');
}
if (defined('MYSQLI_INIT_COMMAND')) {
    mysqli_options($mysqli, MYSQLI_INIT_COMMAND, 'SET NAMES utf8');
}

// No SSL for local connection
if ($ca) {
    if (!mysqli_ssl_set($mysqli, null, null, $ca, null, null)) {
        error_log("mysqli_ssl_set failed");
        echo "mysqli_ssl_set failed";
    }
}

// If available in this PHP build, request server cert verification
if (defined('MYSQLI_OPT_SSL_VERIFY_SERVER_CERT')) {
    mysqli_options($mysqli, MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, true);
}

// Connect (no SSL for local)
if (!mysqli_real_connect($mysqli, $host, $user, $pass, null, $port, null, 0)) {
    $errno = mysqli_connect_errno();
    $err   = mysqli_connect_error();
    error_log("Connect error ($errno): $err");
    echo "Connect error ($errno): $err";
    if ($errno === 1045) {
        echo "<br>Hint: Access denied usually means the user/password is wrong, or the user lacks privileges from this host. Please create 'ci_user' with mysql_native_password and GRANT on veterinaria_VCMS.";
    } elseif ($errno === 2003) {
        echo "<br>Hint: Can't connect. Verify Security Group allows TCP 3306 from your public IP and the cluster is Available.";
    }
    exit(1);
}

echo "Connected: " . mysqli_get_host_info($mysqli) . "\n";

// List databases
$result = mysqli_query($mysqli, 'SHOW DATABASES;');
if ($result === false) {
    error_log("Query error (" . mysqli_errno($mysqli) . "): " . mysqli_error($mysqli));
    echo "Query error (" . mysqli_errno($mysqli) . "): " . mysqli_error($mysqli);
    exit(1);
}

while ($row = mysqli_fetch_row($result)) {
    echo $row[0] . "\n";
}

mysqli_free_result($result);
mysqli_close($mysqli);
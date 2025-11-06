<?php
// Router para el servidor embebido de PHP
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$path = __DIR__ . $uri;

// Si la ruta apunta a un archivo existente (CSS, JS, imágenes, etc.), se sirve directamente
if ($uri !== '/' && file_exists($path) && is_file($path)) {
    return false;
}

// Redirige todas las peticiones al front controller de CodeIgniter
require __DIR__ . '/index.php';
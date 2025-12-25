<?php
if (!defined('WHMCS')) {
    die('This file cannot be accessed directly');
}

$libDir = __DIR__;

$idiomaFile = $libDir . DIRECTORY_SEPARATOR . 'idioma.php';
$configFile = $libDir . DIRECTORY_SEPARATOR . 'mercadopago_config.php';

if (file_exists($idiomaFile)) {
    require_once $idiomaFile;
}
if (file_exists($configFile)) {
    require_once $configFile;
}

// Fallback para não quebrar admin caso idioma.php não carregue
if (!function_exists('traduccion')) {
    function traduccion($idioma, $key) { return $key; }
}

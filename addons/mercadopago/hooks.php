<?php

if (!defined('WHMCS')) {
    die('This file cannot be accessed directly');
}

add_hook('AfterCronJob', 1, function ($vars) {

    $configFile = ROOTDIR . DIRECTORY_SEPARATOR . 'modules'
        . DIRECTORY_SEPARATOR . 'gateways'
        . DIRECTORY_SEPARATOR . 'MercadoPago_Lib'
        . DIRECTORY_SEPARATOR . 'mercadopago_config.php';

    // Evita warning/fatal por include de arquivo inexistente
    if (file_exists($configFile)) {
        require_once $configFile;
    } else {
        // Opcional (recomendado p/ debug): logActivity('MercadoPago hook: config não encontrado: ' . $configFile);
        return;
    }

    // Evita fatal se a classe não carregou
    if (!class_exists('MercadopagoConfig')) {
        // Opcional: logActivity('MercadoPago hook: classe MercadopagoConfig não encontrada');
        return;
    }

    try {
        $obj = new MercadopagoConfig();

        if (method_exists($obj, 'procesarTodosRegistrosCallback')) {
            $obj->procesarTodosRegistrosCallback(10);
        }
    } catch (\Throwable $e) {
        // Opcional: logActivity('MercadoPago hook error: ' . $e->getMessage());
        return;
    }
});

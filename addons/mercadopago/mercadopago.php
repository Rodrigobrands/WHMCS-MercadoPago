<?php

if (!defined('WHMCS')) {
    die('This file cannot be accessed directly');
}

$libBase = ROOTDIR . DIRECTORY_SEPARATOR . 'modules'
    . DIRECTORY_SEPARATOR . 'gateways'
    . DIRECTORY_SEPARATOR . 'MercadoPago_Lib';

$libIdioma = $libBase . DIRECTORY_SEPARATOR . 'idioma.php';
$libConfig = $libBase . DIRECTORY_SEPARATOR . 'mercadopago_config.php';

if (file_exists($libIdioma)) {
    require_once $libIdioma;
}
if (file_exists($libConfig)) {
    require_once $libConfig;
}

// Fallback anti-fatal se a lib não carregou por algum motivo
if (!function_exists('traduccion')) {
    function traduccion($idioma, $key) { return $key; }
}

function mercadopago_config()
{
    $idioma = 'br';

    try {
        if (class_exists('MercadopagoConfig')) {
            $obj = new MercadopagoConfig();
            if (method_exists($obj, 'checkIdioma')) {
                $idioma = $obj->checkIdioma();
            }
        }
    } catch (\Throwable $e) {
        $idioma = 'br';
    }

    return array(
        "name" => "MercadoPago",
        "description" => traduccion($idioma, "mercadopago_config_1"),
        "author" => "MercadoPago",
        "language" => "spanish",
        "version" => "17.3",
        "fields" => array(
            "licencia" => array(
                "FriendlyName" => traduccion($idioma, "mercadopago_config_2"),
                "Type" => "text",
                "Size" => "25",
                "Description" => ""
            ),
            "verificador" => array(
                "FriendlyName" => traduccion($idioma, "mercadopago_config_3"),
                "Type" => "textarea",
                "Rows" => "6",
                "Cols" => "60",
                "Description" => traduccion($idioma, "mercadopago_config_4")
            ),
            "idioma" => array(
                "FriendlyName" => traduccion($idioma, "mercadopago_config_5"),
                "Type" => "dropdown",
                "Options" => array("ar" => "Español", "br" => "Português", "us" => "English"),
                "Default" => "ar",
                "Description" => traduccion($idioma, "mercadopago_config_6")
            )
        )
    );
}

function mercadopago_activate()
{
    $idioma = 'br';

    try {
        if (!class_exists('MercadopagoConfig')) {
            return array("status" => "error", "description" => "MercadopagoConfig não carregou. Verifique MercadoPago_Lib/mercadopago_config.php");
        }

        $obj = new MercadopagoConfig();
        if (method_exists($obj, 'checkIdioma')) {
            $idioma = $obj->checkIdioma();
        }
        if (method_exists($obj, 'crearTablaCustomTransacciones')) {
            $obj->crearTablaCustomTransacciones();
        }
    } catch (\Throwable $e) {
        return array("status" => "error", "description" => "Falha ao ativar: " . $e->getMessage());
    }

    return array("status" => "success", "description" => traduccion($idioma, "mercadopago_activate_1"));
}

function mercadopago_deactivate()
{
    $idioma = 'br';

    try {
        if (class_exists('MercadopagoConfig')) {
            $obj = new MercadopagoConfig();
            if (method_exists($obj, 'checkIdioma')) {
                $idioma = $obj->checkIdioma();
            }
            if (method_exists($obj, 'eliminarTablaCustomTransacciones')) {
                $obj->eliminarTablaCustomTransacciones();
            }
        }
    } catch (\Throwable $e) {
        return array("status" => "error", "description" => "Falha ao desativar: " . $e->getMessage());
    }

    return array("status" => "success", "description" => traduccion($idioma, "mercadopago_deactivate_1"));
}

function mercadopago_output($vars)
{
    // NÃO faça print_r($vars) aqui.
    echo '<h2>MercadoPago</h2>';
    echo '<p>Addon carregado.</p>';
}

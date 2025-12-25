<?php

if (!defined('WHMCS')) {
    die('This file cannot be accessed directly');
}

/**
 * Opcional: inclua dependências aqui, se existirem.
 * Ajuste os caminhos conforme seu módulo.
 */
// $baseDir = __DIR__;
// if (file_exists($baseDir . '/vendor/autoload.php')) {
//     require_once $baseDir . '/vendor/autoload.php';
// }
// if (file_exists($baseDir . '/MercadopagoConfig.php')) {
//     require_once $baseDir . '/MercadopagoConfig.php';
// }

if (!function_exists('traduccion')) {
    function traduccion($idioma, $key)
    {
        // Fallback para não quebrar se o sistema de tradução não estiver carregado
        return $key;
    }
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
        // não faz echo aqui para não quebrar a tela do admin
        $idioma = 'br';
    }

    return array(
        'name'        => 'MercadoPago',
        'description' => traduccion($idioma, 'mercadopago_config_1'),
        'author'      => 'MercadoPago',
        'language'    => 'spanish',
        'version'     => '17.3',
        'fields'      => array(
            'licencia' => array(
                'FriendlyName' => traduccion($idioma, 'mercadopago_config_2'),
                'Type'         => 'text',
                'Size'         => '25',
                'Description'  => '',
            ),
            'verificador' => array(
                'FriendlyName' => traduccion($idioma, 'mercadopago_config_3'),
                'Type'         => 'textarea',
                'Rows'         => '6',
                'Cols'         => '60',
                'Description'  => traduccion($idioma, 'mercadopago_config_4'),
            ),
            'idioma' => array(
                'FriendlyName' => traduccion($idioma, 'mercadopago_config_5'),
                'Type'         => 'dropdown',
                'Options'      => array(
                    'ar' => 'Español',
                    'br' => 'Português',
                    'us' => 'English',
                ),
                'Default'     => 'ar',
                'Description' => traduccion($idioma, 'mercadopago_config_6'),
            ),
        ),
    );
}

function mercadopago_activate()
{
    $idioma = 'br';

    try {
        if (class_exists('MercadopagoConfig')) {
            $obj = new MercadopagoConfig();
            if (method_exists($obj, 'checkIdioma')) {
                $idioma = $obj->checkIdioma();
            }
            if (method_exists($obj, 'crearTablaCustomTransacciones')) {
                $obj->crearTablaCustomTransacciones();
            }
        }
    } catch (\Throwable $e) {
        return array(
            'status'      => 'error',
            'description' => 'Falha ao ativar: ' . $e->getMessage(),
        );
    }

    return array(
        'status'      => 'success',
        'description' => traduccion($idioma, 'mercadopago_activate_1'),
    );
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
        return array(
            'status'      => 'error',
            'description' => 'Falha ao desativar: ' . $e->getMessage(),
        );
    }

    return array(
        'status'      => 'success',
        'description' => traduccion($idioma, 'mercadopago_deactivate_1'),
    );
}

function mercadopago_output($vars)
{
    // NÃO usar echo/print_r bruto aqui; isso pode quebrar o admin.
    // Se quiser depurar, use logActivity() do WHMCS (recomendado) ou mostre HTML controlado.

    echo '<div style="padding:10px">';
    echo '<h2>MercadoPago</h2>';
    echo '<p>Addon carregado com sucesso.</p>';
    echo '</div>';
}

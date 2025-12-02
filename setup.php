<?php

use Glpi\Plugin\Hooks;
use GlpiPlugin\Clicksign\ClickSignTab;

define('PLUGIN_CLICKSIGN_VERSION', '1.0.0');
define("PLUGIN_CLICKSIGN_MIN_GLPI_VERSION", "11.0.0");
define("PLUGIN_CLICKSIGN_MAX_GLPI_VERSION", "11.0.99");

function plugin_init_clicksign()
{
    global $PLUGIN_HOOKS;

    $PLUGIN_HOOKS['csrf_compliant']['clicksign'] = true;

    // Adicionar JavaScript - GLPI 11 usa jQuery
    $PLUGIN_HOOKS[Hooks::ADD_JAVASCRIPT]['clicksign'] = [
        'js/clicksign.js',
    ];

    Plugin::registerClass(ClickSignTab::class, [
        'addtabon' => 'Ticket'
    ]);
}

function plugin_version_clicksign()
{
    return [
        'name' => 'ClickSign Integration',
        'version' => PLUGIN_CLICKSIGN_VERSION,
        'author' => 'Seu Nome',
        'license' => 'GPL-2.0-or-later',
        'homepage' => '',
        'requirements' => [
            'glpi' => [
                'min' => PLUGIN_CLICKSIGN_MIN_GLPI_VERSION,
                'max' => PLUGIN_CLICKSIGN_MAX_GLPI_VERSION,
            ]
        ]
    ];
}

function plugin_clicksign_check_config($verbose = false)
{
    return true;
}
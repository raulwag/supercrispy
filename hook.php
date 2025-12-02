<?php

function plugin_clicksign_install()
{
    // IMPORTANTE: Configure a URL do seu webhook n8n aqui
    $config = new Config();
    Config::setConfigurationValues('plugin:clicksign', [
        'n8n_webhook_url' => 'http://192.168.245.128:5678/webhook/glpi-webhook'
    ]);

    return true;
}

function plugin_clicksign_uninstall()
{
    $config = new Config();
    $config->deleteByCriteria(['context' => 'plugin:clicksign']);

    return true;
}
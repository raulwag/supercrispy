<?php

namespace GlpiPlugin\Clicksign;

use CommonGLPI;
use Glpi\Application\View\TemplateRenderer;
use Ticket;

class ClickSignTab extends CommonGLPI
{
    static function getTypeName($nb = 0)
    {
        return __('Enviar para ClickSign', 'clicksign');
    }

    function getTabNameForItem(CommonGLPI $item, $withtemplate = 0)
    {
        if ($item instanceof Ticket) {
            return self::getTypeName();
        }
        return '';
    }

    static function displayTabContentForItem(CommonGLPI $item, $tabnum = 1, $withtemplate = 0)
    {
        if ($item instanceof Ticket) {
            self::showForTicket($item);
        }
        return true;
    }

    static function showForTicket(Ticket $ticket)
    {
        $config = \Config::getConfigurationValues('plugin:clicksign');
        
        TemplateRenderer::getInstance()->display('@clicksign/clicksign_tab.html.twig', [
            'ticket' => $ticket,
            'webhook_url' => $config['n8n_webhook_url'] ?? ''
        ]);
    }
}
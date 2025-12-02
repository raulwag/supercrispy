// ClickSign Plugin for GLPI 11 - Using jQuery
(function($) {
    'use strict';

    console.log('[ClickSign] Script carregado');

    // Handler delegado: funciona mesmo se o botão for criado depois
    $(document).on('click', '.clicksign-send-btn', function(e) {
        e.preventDefault();

        var $btn        = $(this);
        var ticketId    = $btn.data('ticket-id');
        var webhookUrl  = $btn.data('webhook-url');

        console.log('[ClickSign] Botão clicado');
        console.log('[ClickSign] Ticket ID:', ticketId);
        console.log('[ClickSign] Webhook URL:', webhookUrl);

        if (!confirm('Deseja enviar para ClickSign?')) {
            console.log('[ClickSign] Cancelado pelo usuário');
            return;
        }

        console.log('[ClickSign] Confirmado pelo usuário');

        var $responseDiv = $('#clicksign-response-' + ticketId);

        // Desabilita botão e mostra loading
        $btn.prop('disabled', true);
        $btn.html('<span class="spinner-border spinner-border-sm me-2"></span>Enviando...');

        // Prepara dados
        var data = {
            ticket_id: parseInt(ticketId),
            action: 'send_to_clicksign',
            timestamp: new Date().toISOString()
        };

        console.log('[ClickSign] Enviando dados:', data);

        $.ajax({
            url: webhookUrl,
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(response, textStatus, xhr) {
                console.log('[ClickSign] Sucesso! Status:', xhr.status);
                console.log('[ClickSign] Resposta:', response);

                $responseDiv.show()
                    .removeClass('alert-danger alert-warning')
                    .addClass('alert alert-success mt-3')
                    .html('<i class="ti ti-check"></i> Enviado com sucesso para ClickSign!');
            },
            error: function(xhr, textStatus, errorThrown) {
                console.log('[ClickSign] Erro. Status:', xhr.status);
                console.log('[ClickSign] textStatus:', textStatus);
                console.log('[ClickSign] Erro:', errorThrown);

                if (xhr.status >= 200 && xhr.status < 300) {
                    // Alguns webhooks retornam sem corpo, mas com sucesso
                    $responseDiv.show()
                        .removeClass('alert-danger')
                        .addClass('alert alert-success mt-3')
                        .html('<i class="ti ti-check"></i> Enviado com sucesso!');
                } else {
                    $responseDiv.show()
                        .removeClass('alert-success')
                        .addClass('alert alert-danger mt-3')
                        .html('<i class="ti ti-alert-circle"></i> Erro ao enviar. Verifique o console (F12).');
                }
            },
            complete: function() {
                // Reabilita botão
                $btn.prop('disabled', false);
                $btn.html('<i class="ti ti-send"></i> <span>Enviar</span>');
            }
        });
    });

    // Só pra log mesmo, opcional
    $(document).ready(function() {
        console.log('[ClickSign] Document ready (delegated events ativo)');
    });

})(jQuery);

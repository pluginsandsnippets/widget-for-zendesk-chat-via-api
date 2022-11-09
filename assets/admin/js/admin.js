(function($) {
    
    $(function() {
        var pluginSlug = 'widget-for-zendesk-chat-via-api';
        // Code to fire when the DOM is ready.
        $(document).on('click', 'tr[data-slug="' + pluginSlug + '"] .deactivate', function(e) {
            e.preventDefault();
            $('.ps-zendesk-chat-popup-overlay').addClass('ps-zendesk-chat-active');
            $('body').addClass('ps-zendesk-chat-hidden');
        });

        $(document).on('click', '.ps-zendesk-chat-popup-button-close', function() {
            close_popup();
        });

        $(document).on('click', ".ps-zendesk-chat-serveypanel,tr[data-slug='" + pluginSlug + "'] .deactivate", function(e) {
            e.stopPropagation();
        });

        $(document).click(function() {
            close_popup();
        });

        $('.ps-zendesk-chat-reason label').on('click', function() {
            if ($(this).find('input[type="radio"]').is(':checked')) {
                //$('.ps-zendesk-chat-anonymous').show();
                $(this).next().next('.ps-zendesk-chat-reason-input').show().end().end().parent().siblings().find('.ps-zendesk-chat-reason-input').hide();
            }
        });

        $('input[type="radio"][name="ps-zendesk-chat-selected-reason"]').on('click', function(event) {
            $(".ps-zendesk-chat-popup-allow-deactivate").removeAttr('disabled');
            $(".ps-zendesk-chat-popup-skip-feedback").removeAttr('disabled');
            $('.message.error-message').hide();
            $('.ps-zendesk-chat-pro-message').hide();
        });

        $('.ps-zendesk-chat-reason-pro label').on('click', function() {
            if ($(this).find('input[type="radio"]').is(':checked')) {
                $(this).next('.ps-zendesk-chat-pro-message').show().end().end().parent().siblings().find('.ps-zendesk-chat-reason-input').hide();
                $(this).next('.ps-zendesk-chat-pro-message').show()
                $('.ps-zendesk-chat-popup-allow-deactivate').attr('disabled', 'disabled');
                $('.ps-zendesk-chat-popup-skip-feedback').attr('disabled', 'disabled');
            }
        });

        $(document).on('submit', '#ps-zendesk-chat-deactivate-form', function(event) {
            event.preventDefault();
            
            var _reason = $('input[type="radio"][name="ps-zendesk-chat-selected-reason"]:checked').val();
            var _reason_details = '';
            var deactivate_nonce = $('.ps_widget_for_zendesk_chat_via_api_deactivation_nonce').val();
            
            if (_reason == 2) {
                _reason_details = $(this).find("input[type='text'][name='better_plugin']").val();
            } else if (_reason == 7) {
                _reason_details = $(this).find("input[type='text'][name='other_reason']").val();
            }
            
            if ((_reason == 7 || _reason == 2) && _reason_details == '') {
                $('.message.error-message').show();
                return;
            }
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'ps_widget_for_zendesk_chat_via_api_deactivation',
                    reason: _reason,
                    reason_detail: _reason_details,
                    ps_widget_for_zendesk_chat_via_api_deactivation_nonce: deactivate_nonce
                },
                beforeSend: function() {
                    $(".ps-zendesk-chat-spinner").show();
                    $(".ps-zendesk-chat-popup-allow-deactivate").attr("disabled", "disabled");
                }
            }).done(function() {
                $(".ps-zendesk-chat-spinner").hide();
                $(".ps-zendesk-chat-popup-allow-deactivate").removeAttr("disabled");
                window.location.href = $("tr[data-slug='" + pluginSlug + "'] .deactivate a").attr('href');
            });

        });
        
        $('.ps-zendesk-chat-popup-skip-feedback').on('click', function(e) {
            // e.preventDefault();
            window.location.href = $("tr[data-slug='" + pluginSlug + "'] .deactivate a").attr('href');
        })

        function close_popup() {
            $('.ps-zendesk-chat-popup-overlay').removeClass('ps-zendesk-chat-active');
            $('#ps-zendesk-chat-deactivate-form').trigger("reset");
            $(".ps-zendesk-chat-popup-allow-deactivate").attr('disabled', 'disabled');
            $(".ps-zendesk-chat-reason-input").hide();
            $('body').removeClass('ps-zendesk-chat-hidden');
            $('.message.error-message').hide();
            $('.ps-zendesk-chat-pro-message').hide();
        }
        
    });
})(jQuery);
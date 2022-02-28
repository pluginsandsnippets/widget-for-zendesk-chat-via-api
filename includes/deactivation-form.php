<?php
/**
 * ZendeskChatWidgetViaAPI deactivation Content.
 * @package ZendeskChatWidgetViaAPI
 * @version 1.0.0
 */

// Exit if accessed directly

if (!defined('ABSPATH')) {
    exit;
}

$ps_zendesk_chat_widget_via_api_deactivation_nonce = wp_create_nonce( 'ps_zendesk_chat_widget_via_api_deactivation_nonce' ); 
?>

<div class="ps-zendesk-chat-popup-overlay">
    <div class="ps-zendesk-chat-serveypanel">
        <form action="#" method="post" id="ps-zendesk-chat-deactivate-form">
            <div class="ps-zendesk-chat-popup-header">
                <h2><?php echo sprintf( __( 'Quick Feedback about %s' , 'ps-zendesk-chat-widget-via-api' ), PS_ZENDESK_CHAT_WIDGET_VIA_API_NAME ); ?></h2>
            </div>
            <div class="ps-zendesk-chat-popup-body">
                <h3><?php _e( 'If you have a moment, please let us know why you are deactivating:', 'ps-zendesk-chat-widget-via-api' ); ?></h3>
                <input type="hidden" class="ps_zendesk_chat_widget_via_api_deactivation_nonce" name="ps_zendesk_chat_widget_via_api_deactivation_nonce" value="<?php echo $ps_zendesk_chat_widget_via_api_deactivation_nonce; ?>">
                <ul id="ps-zendesk-chat-reason-list">
                    <li class="ps-zendesk-chat-reason" data-input-type="" data-input-placeholder="">
                        <label>
                            <span>
                                <input type="radio" name="ps-zendesk-chat-selected-reason" value="1">
                            </span>
                            <span class="reason_text"><?php _e( 'I only needed the plugin for a short period', 'ps-zendesk-chat-widget-via-api' ); ?></span>
                        </label>
                        <div class="ps-zendesk-chat-internal-message"></div>
                    </li>
                    <li class="ps-zendesk-chat-reason has-input" data-input-type="textfield">
                        <label>
                            <span>
                                <input type="radio" name="ps-zendesk-chat-selected-reason" value="2">
                            </span>
                            <span class="reason_text"><?php _e( 'I found a better plugin', 'ps-zendesk-chat-widget-via-api' ); ?></span>
                        </label>
                        <div class="ps-zendesk-chat-internal-message"></div>
                        <div class="ps-zendesk-chat-reason-input"><span class="message error-message "><?php _e( 'Kindly tell us the Plugin name.', 'ps-zendesk-chat-widget-via-api' ); ?></span><input type="text" name="better_plugin" placeholder="What's the plugin's name?"></div>
                    </li>
                    <li class="ps-zendesk-chat-reason" data-input-type="" data-input-placeholder="">
                        <label>
                            <span>
                                <input type="radio" name="ps-zendesk-chat-selected-reason" value="3">
                            </span>
                            <span class="reason_text"><?php _e( 'The plugin broke my site', 'ps-zendesk-chat-widget-via-api' ); ?></span>
                        </label>
                        <div class="ps-zendesk-chat-internal-message"></div>
                    </li>
                    <li class="ps-zendesk-chat-reason" data-input-type="" data-input-placeholder="">
                        <label>
                            <span>
                                <input type="radio" name="ps-zendesk-chat-selected-reason" value="4">
                            </span>
                            <span class="reason_text"><?php _e( 'The plugin suddenly stopped working', 'ps-zendesk-chat-widget-via-api' ); ?></span>
                        </label>
                        <div class="ps-zendesk-chat-internal-message"></div>
                    </li>
                    <li class="ps-zendesk-chat-reason" data-input-type="" data-input-placeholder="">
                        <label>
                            <span>
                                <input type="radio" name="ps-zendesk-chat-selected-reason" value="5">
                            </span>
                            <span class="reason_text"><?php _e( 'I no longer need the plugin', 'ps-zendesk-chat-widget-via-api' ); ?></span>
                        </label>
                        <div class="ps-zendesk-chat-internal-message"></div>
                    </li>
                    <li class="ps-zendesk-chat-reason" data-input-type="" data-input-placeholder="">
                        <label>
                            <span>
                                <input type="radio" name="ps-zendesk-chat-selected-reason" value="6">
                            </span>
                            <span class="reason_text"><?php _e( "It's a temporary deactivation. I'm just debugging an issue.", 'ps-zendesk-chat-widget-via-api' ); ?></span>
                        </label>
                        <div class="ps-zendesk-chat-internal-message"></div>
                    </li>
                    <li class="ps-zendesk-chat-reason has-input" data-input-type="textfield" >
                        <label>
                            <span>
                                <input type="radio" name="ps-zendesk-chat-selected-reason" value="7">
                            </span>
                            <span class="reason_text"><?php _e( 'Other', 'ps-zendesk-chat-widget-via-api' ); ?></span>
                        </label>
                        <div class="ps-zendesk-chat-internal-message"></div>
                        <div class="ps-zendesk-chat-reason-input"><span class="message error-message "><?php _e( 'Kindly tell us the reason so we can improve.', 'ps-zendesk-chat-widget-via-api' ); ?></span><input type="text" name="other_reason" placeholder="Kindly tell us the reason so we can improve."></div>
                    </li>
                </ul>
            </div>
            <div class="ps-zendesk-chat-popup-footer">
                <label class="ps-zendesk-chat-anonymous"><input type="checkbox" /><?php _e( 'Anonymous feedback', 'ps-zendesk-chat-widget-via-api' ); ?></label>
                <input type="button" class="button button-secondary button-skip ps-zendesk-chat-popup-skip-feedback" value="<?php _e( 'Skip & Deactivate', 'ps-zendesk-chat-widget-via-api'); ?>" />
                <div class="action-btns">
                    <span class="ps-zendesk-chat-spinner"><img src="<?php echo admin_url( '/images/spinner.gif' ); ?>" alt=""></span>
                    <input type="submit" class="button button-secondary button-deactivate ps-zendesk-chat-popup-allow-deactivate" value="<?php _e( 'Submit & Deactivate', 'ps-zendesk-chat-widget-via-api'); ?>" disabled="disabled" />
                    <a href="#" class="button button-primary ps-zendesk-chat-popup-button-close"><?php _e( 'Cancel', 'ps-zendesk-chat-widget-via-api' ); ?></a>
                </div>
            </div>
        </form>
    </div>
</div>
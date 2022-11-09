<?php
/**
 * ZendeskChatWidgetViaAPI deactivation Content.
 * @package ZendeskChatWidgetViaAPI
 * @version 1.5
 */

// Exit if accessed directly

if (!defined('ABSPATH')) {
    exit;
}

$code       = $this->main_instance->get_api_code();
$delay_time = $this->main_instance->get_api_delay_time();

?>

<h1><?php __( 'Zendesk Chat Settings', 'widget-for-zendesk-chat-via-api' ); ?></h1>

<form method="POST">
    <p>
        <?php echo __( 'Please enter your Zendesk Chat Account Key so that the Zendesk Chat Widget can be loaded via API. After entering the key please clear all caches and please disable the regular Zendesk Chat plugin as it will no longer be needed. Now the Zendesk Chat widget will be loaded via API with a slight time delay which improves the page loading speed of your website. Make your website faster with this plugin.', 'widget-for-zendesk-chat-via-api' ); ?>
    </p>
    <p>
        <a href="https://support.zendesk.com/hc/en-us/articles/4408825772698-How-do-I-find-my-Chat-Account-Key-" target="_blank">
            <?php echo __( 'Find your Account Key', 'widget-for-zendesk-chat-via-api' ); ?>
        </a>
    </p>

    <div class="widget-for-zendesk-chat-via-api-field">
        <label for="widget-for-zendesk-chat-via-api-code">
            <?php echo __( 'Zendesk Chat API Code', 'widget-for-zendesk-chat-via-api' ); ?>
        </label>
        <input type="hidden" name="ps_zendesk_chat_widget_api_code_nonce" value="<?php echo esc_attr( wp_create_nonce( 'ps_zendesk_chat_widget_api_code_nonce' ) ) ?>" />
        <input type="text" name="ps_zendesk_chat_widget_api_code" value="<?php echo esc_attr( $code ) ?>" />
    </div>
    <div class="widget-for-zendesk-chat-via-api-field">
        <label for="widget-for-zendesk-chat-via-api-delay-time">
            <?php echo __( 'Zendesk Chat API Delay Time', 'widget-for-zendesk-chat-via-api' ); ?>
        </label>
        <input type="number" min="10" name="ps_zendesk_chat_widget_api_delay_time" value="<?php echo esc_attr( $delay_time ) ?>" />
        <p><?php _e( 'This is the duration (in seconds) which the plugin will wait before loading the chat widget', 'widget-for-zendesk-chat-via-api' ); ?></p>
    </div>
    <div class="widget-for-zendesk-chat-via-api-submit">
        <button type="submit" class="button-primary">
            <?php echo __( 'Save', 'widget-for-zendesk-chat-via-api' ); ?>
        </button>
    </div>
</form>
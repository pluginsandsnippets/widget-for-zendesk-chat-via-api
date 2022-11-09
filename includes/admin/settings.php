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

<?php require PS_WIDGET_FOR_ZENDESK_CHAT_VIA_API_DIR . 'includes/admin/subscription-callout.php'; ?>

<form method="POST">
    <p>
        <?php echo __( 'Please enter your Zendesk Chat Account Key so that the Zendesk Chat Widget can be loaded via API. After entering the key please clear all caches and please disable the regular Zendesk Chat plugin as it will no longer be needed. Now the Zendesk Chat widget will be loaded via API with a slight time delay which improves the page loading speed of your website. Make your website faster with this plugin.', 'widget-for-zendesk-chat-via-api' ); ?>
    </p>
    <p>
        <a href="https://support.zendesk.com/hc/en-us/articles/4408825772698-How-do-I-find-my-Chat-Account-Key-" target="_blank">
            <?php echo __( 'Find your Account Key', 'widget-for-zendesk-chat-via-api' ); ?>
        </a>
    </p>

    <div class="ps-wfzcva-field">
        <label for="ps-wfzcva-code">
            <?php echo __( 'Zendesk Chat API Code', 'widget-for-zendesk-chat-via-api' ); ?>
        </label>
        <input type="hidden" name="ps_zendesk_chat_widget_api_code_nonce" value="<?php echo esc_attr( wp_create_nonce( 'ps_zendesk_chat_widget_api_code_nonce' ) ) ?>" />
        <input type="text" name="ps_zendesk_chat_widget_api_code" value="<?php echo esc_attr( $code ) ?>" />
    </div>
    <div class="ps-wfzcva-field">
        <label for="ps-wfzcva-delay-time">
            <?php echo __( 'Zendesk Chat API Delay Time', 'widget-for-zendesk-chat-via-api' ); ?>
        </label>
        <input type="number" min="10" name="ps_zendesk_chat_widget_api_delay_time" value="<?php echo esc_attr( $delay_time ) ?>" />
        <p><?php _e( 'This is the duration (in seconds) which the plugin will wait before loading the chat widget', 'widget-for-zendesk-chat-via-api' ); ?></p>
    </div>
    <div class="ps-wfzcva-submit">
        <button type="submit" class="button-primary">
            <?php echo __( 'Save', 'widget-for-zendesk-chat-via-api' ); ?>
        </button>
    </div>
</form>

<?php if ( isset( $promos ) && ! empty( $promos ) ): ?>
    <div class="ps-wfzcva-other-plugins">
        <?php foreach ( $promos as $promo ): ?>
            <div class="ps-wfzcva-other-plugin">
                <div class="ps-wfzcva-other-plugin-title">
                    <a href="<?php echo esc_url( $promo['url'] ); ?>" target="_blank"><?php echo $promo['title']; ?></a>
                </div>
                <div class="ps-wfzcva-other-plugin-links">
                    <div><a href="<?php echo esc_url( $promo['url'] ); ?>" target="_blank"><?php _e( 'View', 'ps-plugin-template' ); ?></a></div>
                    <?php if ( isset( $promo['documentation'] ) ): ?>
                        <div><a href="<?php echo esc_url( $promo['documentation'] ); ?>" target="_blank"><?php _e( 'Documentation', 'ps-plugin-template' ); ?></a></div>
                    <?php endif; ?>
                    <?php if ( isset( $promo['support'] ) ): ?>
                        <div><a href="<?php echo esc_url( $promo['support'] ); ?>" target="_blank"><?php _e( 'Support', 'ps-plugin-template' ); ?></a></div>
                    <?php endif; ?>
                </div>
                <div class="ps-wfzcva-other-plugin-image"><a href="<?php echo esc_url( $promo['url'] ); ?>" target="_blank"><img src="<?php echo esc_url( $promo['image'] ); ?>" /></a></div>
                <div class="ps-wfzcva-other-plugin-desc">
                    <?php if ( $promo['initial_link'] ) : ?>
                    <a href="<?php echo esc_url( $promo['url'] ); ?>" target="_blank"><?php echo $promo['title']; ?></a> 
                    <?php endif; ?>

                    <?php echo $promo['description']; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
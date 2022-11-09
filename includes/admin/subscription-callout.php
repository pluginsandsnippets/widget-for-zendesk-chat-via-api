<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="widget-for-zendesk-chat-via-api-subscription-callout-wrapper">
	<div class="widget-for-zendesk-chat-via-api-subscription-callout">
		<div class="widget-for-zendesk-chat-via-api-subscription-callout-main">
			<h3><?php _e( 'Subscribe to our Newsletter', 'ps-plugin-template' ); ?></h3>
			<p><?php _e( 'Receive updates from <a href="https://www.pluginsandsnippets.com" target="_blank">Plugins & Snippets</a> with respect to WordPress plugins aimed to enhance the conversion rates of your web stores.', 'ps-plugin-template' ); ?></p>

			<div class="widget-for-zendesk-chat-via-api-subscription-error" style="display: none;"><?php _e( 'There was an error in processing your request, please try again.', 'ps-plugin-template' ); ?></div>

			<form method="POST" class="widget-for-zendesk-chat-via-api-subscription-form">
				<input type="email" required value="<?php echo esc_attr( get_option( 'admin_email' ) ); ?>">
				
				<div class="widget-for-zendesk-chat-via-api-subscription-actions">
					<button class="button-primary"><?php _e( 'Subscribe', 'ps-plugin-template' ); ?></button>
				</div>
			</form>
		</div>

		<div class="widget-for-zendesk-chat-via-api-subscription-callout-thanks" style="display: none;">
			<h3><?php _e( 'Thank you for signing up to our Newsletter!', 'ps-plugin-template' ); ?></h3>
		</div>

	</div>
</div>
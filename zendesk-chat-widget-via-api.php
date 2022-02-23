<?php
/**
 * Plugin Name:       PS Zendesk Chat
 * Plugin URI:        https://www.pluginsandsnippets.com/
 * Description:       This plugin loads Zendesk Chat widget (formerly Zopim chat) via API with a slight time delay. This improves the page loading speed of your website compared to the standard Zendesk Chat plugin. Make your website faster loading Zendesk Chat widget this way!
 * Version:           1.1.0
 * Author:            Plugins & Snippets
 * Author URI:        https://www.pluginsandsnippets.com
 * Text Domain:       zendesk-chat-widge-via-api
 * Requires at least: 3.5
 * Tested up to:      5.9
 *
 * @author            PluginsandSnippets.com
 * @copyright         All rights reserved Copyright (c) 2022, PluginsandSnippets.com
 *
 */

if( ! class_exists( 'PS_Zendesk_Chat' ) ) {	
	class PS_Zendesk_Chat {
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'create_options_menu' ) );
			add_action( 'wp_footer', array( $this, 'init_zendesk_chat_widget' ) );
		}

		public function get_api_code() {
			return get_option( 'ps_zendesk_code' );
		}

		public function create_options_menu() {

			add_submenu_page(
				'options-general.php',
				__( 'Zendesk Chat Settings', 'ps-zendesk-chat' ),
				__( 'Zendesk Chat Settings', 'ps-zendesk-chat' ),
				'manage_options',
				'ps-zendesk-chat',
				array( $this, 'options_page' )
			);
		}

		public function options_page() {

			if( isset( $_POST['ps_zendesk_code'] ) ) {
				update_option( 'ps_zendesk_code', $_POST['ps_zendesk_code'], false );
			}

			$code = $this->get_api_code();
			echo '<h1>' . __( 'Zendesk Chat Settings', 'ps-zendesk-chat' ) . '</h1>';
			echo 
				'<style>
					.ps-zendesk-chat-field label {
					    display: block;
					    font-weight: 600;
					    margin: 0 0 10px;
					}

					.ps-zendesk-chat-field input {
					    width: 100%;
					}

					.ps-zendesk-chat-field {
					    max-width: 600px;
					    padding-right: 10px;
					    margin: 0 0 10px;
					}
				</style>';
			echo '<form method="POST">';
				echo '<p><a href="https://support.zendesk.com/hc/en-us/articles/4408825772698-How-do-I-find-my-Chat-Account-Key-" target="_blank">' . __( 'Find your Account Key', 'fiery' ) . '</a></p>';
				echo '<div class="ps-zendesk-chat-field">';
					echo '<label for="ps-zendesk-chat-code">' . __( 'Zendesk Chat API Code', 'ps-zendesk-chat' ) . '</label>';
					echo '<input type="text" name="ps_zendesk_code" value="' . esc_attr( $code ) . '" />';
				echo '</div>';

				echo '<div class="ps-zendesk-chat-submit">
						<button type="submit" class="button-primary">' . __( 'Save', 'ps-zendesk-chat' ) . '</button>
					</div>';
			echo '</form>';
		}
		
		public function init_zendesk_chat_widget() {
			$code = $this->get_api_code();

			if( empty( $code ) ) {
				return;
			}

			$markup =
				'<script>
					function load_zopim() {
						window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
						d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
						_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute(\'charset\',\'utf-8\');
						$.src=\'//v2.zopim.com/?' . $code . '\';z.t=+new Date;$.
						type=\'text/javascript\';e.parentNode.insertBefore($,e)})(document,\'script\');
					}
				</script>';

			$current_user_data_set = '';

			if( is_user_logged_in() ) {
				$current_user = wp_get_current_user();
				$first_name = $current_user->display_name;
				$user_email = $current_user->user_email;

				$current_user_data_set = '$zopim(function(){$zopim.livechat.set({name: \'' . $first_name . '\', email: \'' . $user_email . '\'}); });';
			}

			$markup .= '<script>';
			$markup .= 
				'function call_zopim() {
					' . $current_user_data_set . '
					$zopim( function() {});
				}';

			// Following JS loads and calls widget when one of two criterian is met
			$markup .= 
				'var zopim_loaded = false;
				jQuery(window).on(\'scroll\', function() {
					window.setTimeout(function() {
						if( ! zopim_loaded ) {
							load_zopim();
							call_zopim();
							zopim_loaded = true;
						}
					}, 3000);
				});

				jQuery(window).on(\'load\', function() {
					window.setTimeout(function() {
						if( ! zopim_loaded ) {
							load_zopim();
							call_zopim();
							zopim_loaded = true;
						}
					}, 10000);
				});';

			$markup .= '</script>';
			
			echo $markup;
		}
	}

	// Instantiate the class
	new PS_Zendesk_Chat();
}
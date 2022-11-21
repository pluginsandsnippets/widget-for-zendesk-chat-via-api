<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'PS_Zendesk_Chat_Widget_Via_Api_Admin' ) ) {
	class PS_Zendesk_Chat_Widget_Via_Api_Admin {
		
		// holds reference to main class
		private $main_instance;

		public function __construct( $instance ) {
			$this->main_instance = $instance;
			$this->hooks();
		}

		public function hooks() {
			add_action( 'admin_menu', array(
				$this,
				'create_options_menu' 
			) );
		   
			add_action( 'wp_ajax_ps_widget_for_zendesk_chat_via_api_review_notice', array(
				$this,
				'dismiss_review_notice' 
			) );
			
			if ( is_admin() ) {
				add_action( 'admin_enqueue_scripts', array(
					$this,
					'load_admin_css' 
				) );
			}

			if ( is_admin() && get_option( 'ps_widget_for_zendesk_chat_via_api_review_time' ) && get_option( 'ps_widget_for_zendesk_chat_via_api_review_time' ) < time() && !get_option( 'ps_widget_for_zendesk_chat_via_api_dismiss_review_notice' ) ) {
				add_action( 'admin_notices', array(
					$this,
					'notice_review' 
				) );
				add_action( 'admin_footer', array(
					$this,
					'notice_review_script' 
				) );
			}

			add_action( 'plugin_row_meta', array(
				$this,
				'add_action_links' 
			), 10, 2 );
			add_action( 'admin_footer', array(
				$this,
				'add_deactive_modal' 
			) );
			add_action( 'wp_ajax_ps_widget_for_zendesk_chat_via_api_deactivation', array(
				$this,
				'handle_deactivation_response' 
			) );
			add_action( 'plugin_action_links', array(
				$this,
				'action_links' 
			), 10, 2 );

			add_action( 'wp_ajax_widget_for_zendesk_chat_via_api_handle_subscription_request' , array( $this, 'process_subscription' ) );
			add_action( 'wp_ajax_widget_for_zendesk_chat_via_api_subscription_popup_shown' , array( $this, 'subscription_shown' ) );
		}

		public function create_options_menu() {
			add_submenu_page( 'options-general.php', __( 'Zendesk Chat Settings', 'widget-for-zendesk-chat-via-api' ), __( 'Zendesk Chat Settings', 'widget-for-zendesk-chat-via-api' ), 'manage_options', 'widget-for-zendesk-chat-via-api', array(
				$this,
				'options_page' 
			) );
		}

		public function options_page() {

			if ( current_user_can( 'manage_options' ) && isset( $_REQUEST['ps_zendesk_chat_widget_api_code_nonce'] ) && wp_verify_nonce( $_REQUEST['ps_zendesk_chat_widget_api_code_nonce'], 'ps_zendesk_chat_widget_api_code_nonce' ) && isset( $_POST['ps_zendesk_chat_widget_api_code'] ) ) {

				update_option( 'ps_zendesk_chat_widget_api_code', sanitize_text_field( wp_unslash( $_POST['ps_zendesk_chat_widget_api_code'] ) ), false );
				
				update_option( 'ps_zendesk_chat_widget_api_delay_time', sanitize_text_field( intval( $_POST['ps_zendesk_chat_widget_api_delay_time'] ) ), false );
			}

			require_once PS_WIDGET_FOR_ZENDESK_CHAT_VIA_API_DIR . 'includes/admin/promos-configuration.php';
			require_once PS_WIDGET_FOR_ZENDESK_CHAT_VIA_API_DIR . 'includes/admin/settings.php';
		}

		/**
		 * Disables the notice about leaving a review.
		 */
		public function dismiss_review_notice() {
			update_option( 'ps_widget_for_zendesk_chat_via_api_dismiss_review_notice', true, false );
			wp_die();
		}

		public function load_admin_css() {
			wp_enqueue_script( 'ps-wfzcva-admin-js', PS_WIDGET_FOR_ZENDESK_CHAT_VIA_API_PLUGIN_URL . 'assets/admin/js/admin.min.js' );
			wp_enqueue_style( 'ps-wfzcva-admin-css', PS_WIDGET_FOR_ZENDESK_CHAT_VIA_API_PLUGIN_URL . 'assets/admin/css/admin.min.css', array(), PS_WIDGET_FOR_ZENDESK_CHAT_VIA_API_VER, 'all' );
		}

		/**
		 * Ask the user to leave a review for the plugin.
		 */
		public function notice_review() {
			global $current_user;
			wp_get_current_user();
			$user_n = '';
			
			if ( ! empty( $current_user->display_name ) ) {
				$user_n = " " . $current_user->display_name;
			}
			
			echo "<div id='ps-wfzcva-review' class='notice notice-info is-dismissible'><p>" . sprintf( __( "Hi%s, Thank you for using <b>" . PS_WIDGET_FOR_ZENDESK_CHAT_VIA_API_NAME . "</b>. Please don't forget to rate our plugin. We sincerely appreciate your feedback.", 'widget-for-zendesk-chat-via-api' ), $user_n ) . '<br><a target="_blank" href="' . PS_WIDGET_FOR_ZENDESK_CHAT_VIA_API_REVIEW_URL . '" class="button-secondary">' . esc_html__( 'Post Review', 'widget-for-zendesk-chat-via-api' ) . '</a>' . '</p></div>';
		}
		
		/**
		 * Loads the inline script to dismiss the review notice.
		 */
		public function notice_review_script() {
			echo "<script>\n" . "jQuery(document).on('click', '#ps-wfzcva-review .notice-dismiss', function() {\n" . "\tvar ps_widget_for_zendesk_chat_via_api_review_data = {\n" . "\t\taction: 'ps_widget_for_zendesk_chat_via_api_review_notice',\n" . "\t};\n" . "\tjQuery.post(ajaxurl, ps_widget_for_zendesk_chat_via_api_review_data, function(response) {\n" . "\t\tif (response) {\n" . "\t\t\tconsole.log(response);\n" . "\t\t}\n" . "\t});\n" . "});\n" . "</script>\n";
		}
		
		/**
		 * Add support link
		 *
		 * @since 1.0.0
		 * @param array $plugin_meta
		 * @param string $plugin_file
		 */
		public function add_action_links( $plugin_meta, $plugin_file ) {
			
			if ( $plugin_file === plugin_basename( __FILE__ ) ) {
				$link = '<a href="' . PS_WIDGET_FOR_ZENDESK_CHAT_VIA_API_DOCUMENTATION_URL . '" target="_blank">' . __( 'Documentation', 'widget-for-zendesk-chat-via-api' ) . '</a>';
				
				array_push( $plugin_meta, $link );

				$link = '<a href="' . PS_WIDGET_FOR_ZENDESK_CHAT_VIA_API_OPEN_TICKET_URL . '" target="_blank">' . __( 'Open Support Ticket', 'widget-for-zendesk-chat-via-api' ) . '</a>';
				
				array_push( $plugin_meta, $link );

				$link = '<a href="' . PS_WIDGET_FOR_ZENDESK_CHAT_VIA_API_REVIEW_URL . '" target="_blank">' . __( 'Post Review', 'widget-for-zendesk-chat-via-api' ) . '</a>';

				array_push( $plugin_meta, $link );

			}
			
			return $plugin_meta;
		}
		
		/**
		 * Add deactivate modal layout.
		 */
		public function add_deactive_modal() {
			global $pagenow;
			
			if ( 'plugins.php' !== $pagenow ) {
				return;
			}

			include PS_WIDGET_FOR_ZENDESK_CHAT_VIA_API_DIR . 'includes/admin/deactivation-form.php';
		}
		
		/**
		 * Called after the user has submitted his reason for deactivating the plugin.
		 *
		 * @since  1.0.0
		 */
		public function handle_deactivation_response() {

			wp_verify_nonce( $_REQUEST['ps_widget_for_zendesk_chat_via_api_deactivation_nonce'], 'ps_widget_for_zendesk_chat_via_api_deactivation_nonce' );
			
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die();
			}
			
			$reason_id = intval( sanitize_text_field( wp_unslash( $_POST['reason'] ) ) );
			
			if ( empty( $reason_id ) ) {
				wp_die();
			}
			
			$reason_info = sanitize_text_field( wp_unslash( $_POST['reason_detail'] ) );
			
			if ( 1 === $reason_id ) {
				$reason_text = 'I only needed the plugin for a short period';
			} elseif ( 2 === $reason_id ) {
				$reason_text = 'I found a better plugin';
			} elseif ( 3 === $reason_id ) {
				$reason_text = 'The plugin broke my site';
			} elseif ( 4 === $reason_id ) {
				$reason_text = 'The plugin suddenly stopped working';
			} elseif ( 5 === $reason_id ) {
				$reason_text = 'I no longer need the plugin';
			} elseif ( 6 === $reason_id ) {
				$reason_text = 'It\'s a temporary deactivation. I\'m just debugging an issue.';
			} elseif ( 7 === $reason_id ) {
				$reason_text = 'Other';
			}
			
			$cuurent_user = wp_get_current_user();
			
			$options = array(
				'plugin_name'       => PS_WIDGET_FOR_ZENDESK_CHAT_VIA_API_NAME,
				'plugin_version'    => PS_WIDGET_FOR_ZENDESK_CHAT_VIA_API_VER,
				'reason_id'         => $reason_id,
				'reason_text'       => $reason_text,
				'reason_info'       => $reason_info,
				'display_name'      => $cuurent_user->display_name,
				'email'             => get_option( 'admin_email' ),
				'website'           => get_site_url(),
				'blog_language'     => get_bloginfo( 'language' ),
				'wordpress_version' => get_bloginfo( 'version' ),
				'php_version'       => PHP_VERSION 
			);
			
			$to      = 'info@pluginsandsnippets.com';
			$subject = 'Plugin Uninstallation';
			
			$body    = '<p>Plugin Name: ' . PS_WIDGET_FOR_ZENDESK_CHAT_VIA_API_NAME . '</p>';
			$body   .= '<p>Plugin Version: ' . PS_WIDGET_FOR_ZENDESK_CHAT_VIA_API_VER . '</p>';
			$body   .= '<p>Reason: ' . $reason_text . '</p>';
			$body   .= '<p>Reason Info: ' . $reason_info . '</p>';
			$body   .= '<p>Admin Name: ' . $cuurent_user->display_name . '</p>';
			$body   .= '<p>Admin Email: ' . get_option( 'admin_email' ) . '</p>';
			$body   .= '<p>Website: ' . get_site_url() . '</p>';
			$body   .= '<p>Website Language: ' . get_bloginfo( 'language' ) . '</p>';
			$body   .= '<p>Wordpress Version: ' . get_bloginfo( 'version' ) . '</p>';
			$body   .= '<p>PHP Version: ' . PHP_VERSION . '</p>';
			
			$headers = array(
				'Content-Type: text/html; charset=UTF-8' 
			);
			
			wp_mail( $to, $subject, $body, $headers );
			
			wp_die();
		}
		
		/**
		 * Add a link to the settings page to the plugins list
		 *
		 * @since  1.0.0
		 */
		public function action_links( $links, $file ) {
			
			static $this_plugin;
			
			if ( empty( $this_plugin ) ) {
				$this_plugin = 'widget-for-zendesk-chat-via-api/widget-for-zendesk-chat-via-api.php';
			}
			
			if ( $file == $this_plugin ) {
				$settings_link = sprintf( esc_html__( '%1$s Settings %2$s', 'widget-for-zendesk-chat-via-api' ), '<a href="' . admin_url( 'options-general.php?page=widget-for-zendesk-chat-via-api' ) . '">', '</a>' );
				
				array_unshift( $links, $settings_link );

			}
			
			return $links;
		}

		public function process_subscription() {
			if ( isset( $_POST['email'] ) && filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) ) {
				$email = $_POST['email'];
			} else {
				$email = get_option( 'admin_email' );
			}

			wp_remote_post( PS_WIDGET_FOR_ZENDESK_CHAT_VIA_API_SUBSCRIBE_URL, array(
				'body' => array(
					'email'       => $email,
					'plugin_name' => PS_WIDGET_FOR_ZENDESK_CHAT_VIA_API_NAME,
				),
			) );

			if ( ! isset( $_POST['from_callout'] ) ) {
				update_option( 'widget_for_zendesk_chat_via_api_subscription_shown', 'y', false );
			}
			
			wp_send_json( array(
				'processed' => 1,
			) );
		}

		public function subscription_shown() {
			
			update_option( 'widget_for_zendesk_chat_via_api_subscription_shown', 'y', false );
			
			wp_send_json( array(
				'processed' => 1,
			) );
		}

	}
}
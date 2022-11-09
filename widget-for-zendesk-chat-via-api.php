<?php
/**
 * Plugin Name:       Widget for Zendesk Chat via API
 * Plugin URI:        https://wordpress.org/plugins/widget-for-zendesk-chat-via-api/
 * Description:       This plugin loads Zendesk Chat widget (formerly Zopim chat) via API with a slight time delay. This improves the page loading speed of your website compared to the standard Zendesk Chat plugin. Make your website faster loading Zendesk Chat widget this way!
 * Version:           1.10
 * Author:            Plugins & Snippets
 * Author URI:        https://www.pluginsandsnippets.com
 * Text Domain:       widget-for-zendesk-chat-via-api
 * Requires at least: 3.5
 * Tested up to:      5.9.2
 *
 * @author            PluginsandSnippets.com
 * @copyright         All rights reserved Copyright (c) 2022, PluginsandSnippets.com
 *
 */

// Exit if accessed directly

if (!defined('ABSPATH')) {
    exit;
}

if ( !class_exists( 'PS_Zendesk_Chat_Widget_Via_Api' ) ) {
    class PS_Zendesk_Chat_Widget_Via_Api {
        
        public function __construct() {
            
            define( 'PS_WIDGET_FOR_ZENDESK_CHAT_VIA_API_VER', '1.10' );
            define( 'PS_WIDGET_FOR_ZENDESK_CHAT_VIA_API_NAME', 'Widget for Zendesk Chat via API' );
            define( 'PS_WIDGET_FOR_ZENDESK_CHAT_VIA_API_DIR', plugin_dir_path( __FILE__ ) );
            define( 'PS_WIDGET_FOR_ZENDESK_CHAT_VIA_API_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
            define( 'PS_WIDGET_FOR_ZENDESK_CHAT_VIA_API_DOCUMENTATION_URL', 'https://wordpress.org/plugins/widget-for-zendesk-chat-via-api/' );
            define( 'PS_WIDGET_FOR_ZENDESK_CHAT_VIA_API_OPEN_TICKET_URL', 'https://www.pluginsandsnippets.com/open-ticket/' );
            define( 'PS_WIDGET_FOR_ZENDESK_CHAT_VIA_API_REVIEW_URL', 'https://wordpress.org/plugins/widget-for-zendesk-chat-via-api/reviews/#new-post' );

            define( 'PS_WIDGET_FOR_ZENDESK_CHAT_VIA_API_SUBSCRIBE_URL', 'https://www.pluginsandsnippets.com/?ps-subscription-request=1' );
            
            add_action( 'wp_footer', array(
                $this,
                'init_zendesk_chat_widget' 
            ) );

            if ( !get_option( 'ps_widget_for_zendesk_chat_via_api_review_time' ) ) {
                $review_time = time() + 7 * DAY_IN_SECONDS;
                add_option( 'ps_widget_for_zendesk_chat_via_api_review_time', $review_time, '', false );
            }

            // include and load admin class
            require_once PS_WIDGET_FOR_ZENDESK_CHAT_VIA_API_DIR . 'includes/admin/admin.php';
            new PS_Zendesk_Chat_Widget_Via_Api_Admin( $this );
            
        }
        
        public function get_api_code() {
            return get_option( 'ps_zendesk_chat_widget_api_code' );
        }
        
        public function get_api_delay_time() {
            $delay_time = intval( get_option( 'ps_zendesk_chat_widget_api_delay_time' ) );

            // delay time is forced to be at least 10 seconds
            if( empty( $delay_time ) || $delay_time < 10 ) {
                $delay_time = 10;
            }

            return $delay_time;
        }
        
    }
    
    // Instantiate the class
    new PS_Zendesk_Chat_Widget_Via_Api();
}

<?php
/**
 * Assets class for Custom Header Banner
 *
 * @package Custom_Header_Banner
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Assets class
 */
class CHB_Assets {

    /**
     * Constructor
     */
    public function __construct() {
        // Enqueue scripts and styles
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
    }

    /**
     * Enqueue frontend assets
     */
    public function enqueue_frontend_assets() {
        wp_enqueue_style(
            'custom-header-banner',
            CHB_PLUGIN_URL . 'assets/css/frontend.css',
            array(),
            CHB_PLUGIN_VERSION
        );
        
        wp_enqueue_script(
            'custom-header-banner',
            CHB_PLUGIN_URL . 'assets/js/frontend.js',
            array('jquery'),
            CHB_PLUGIN_VERSION,
            true
        );
        
        // Pass plugin settings to JavaScript
        wp_localize_script('custom-header-banner', 'chbSettings', array(
            'bannerType' => get_option('chb_banner_type', 'marquee'),
            'sliderSpeed' => get_option('chb_slider_speed', 3) * 1000, // Convert to milliseconds
            'animationType' => get_option('chb_animation_type', 'slide'),
            'showArrows' => get_option('chb_show_arrows', 'yes'),
            'arrowLeft' => CHB_PLUGIN_URL . 'assets/images/arrow-left.svg',
            'arrowRight' => CHB_PLUGIN_URL . 'assets/images/arrow-right.svg',
        ));
    }

    /**
     * Enqueue admin assets
     *
     * @param string $hook Current admin page
     */
    public function enqueue_admin_assets($hook) {
        if ('toplevel_page_custom-header-banner' !== $hook) {
            return;
        }
        
        // WordPress core scripts
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
        
        // Admin assets
        wp_enqueue_style(
            'custom-header-banner-admin',
            CHB_PLUGIN_URL . 'assets/css/admin.css',
            array(),
            CHB_PLUGIN_VERSION
        );
        
        wp_enqueue_script(
            'custom-header-banner-admin',
            CHB_PLUGIN_URL . 'assets/js/admin.js',
            array('jquery', 'wp-color-picker'),
            CHB_PLUGIN_VERSION,
            true
        );
    }

    /**
     * Get SVG content
     *
     * @param string $file SVG file name
     *
     * @return string SVG content
     */
    public function get_svg($file) {
        $file_path = CHB_PLUGIN_DIR . 'assets/images/' . $file . '.svg';
        
        if (file_exists($file_path)) {
            return file_get_contents($file_path);
        }
        
        return '';
    }
}
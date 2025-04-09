<?php
/**
 * Frontend class for Custom Header Banner
 *
 * @package Custom_Header_Banner
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Frontend class
 */
class CHB_Frontend {

    /**
     * Constructor
     */
    public function __construct() {
        // Display header banner on frontend
        add_action('wp_head', array($this, 'display_header_banner'));
    }

    /**
     * Display header banner on frontend
     */
    public function display_header_banner() {
        // Get settings
        $settings = chb_init()->settings;
        
        $banner_type = $settings->get_setting('chb_banner_type', 'marquee');
        $bg_color = $settings->get_setting('chb_background_color', '#000000');
        $text_color = $settings->get_setting('chb_text_color', '#ffffff');
        $font_size = $settings->get_setting('chb_font_size', '14');
        $font_weight = $settings->get_setting('chb_font_weight', '600');
        $animation_type = $settings->get_setting('chb_animation_type', 'slide');
        $show_arrows = $settings->get_setting('chb_show_arrows', 'yes');
        
        // Get assets instance for SVG
        $assets = chb_init()->assets;
        
        // Include banner template
        include CHB_PLUGIN_DIR . 'templates/banner-display.php';
    }
}
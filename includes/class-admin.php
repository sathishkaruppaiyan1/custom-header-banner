<?php
/**
 * Admin class for Custom Header Banner
 *
 * @package Custom_Header_Banner
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Admin class
 */
class CHB_Admin {

    /**
     * Constructor
     */
    public function __construct() {
        // Admin menu
        add_action('admin_menu', array($this, 'register_admin_menu'));
    }

    /**
     * Register admin menu
     */
    public function register_admin_menu() {
        add_menu_page(
            __('Header Banner', 'custom-header-banner'),
            __('Header Banner', 'custom-header-banner'),
            'manage_options',
            'custom-header-banner',
            array($this, 'admin_page'),
            'dashicons-megaphone',
            58
        );
    }

    /**
     * Admin page content
     */
    public function admin_page() {
        // Get settings instance
        $settings = chb_init()->settings;
        
        // Active tab
        $active_tab = $settings->get_setting('chb_active_tab', 'general');
        
        // Include admin page template
        include CHB_PLUGIN_DIR . 'templates/admin-page.php';
    }

    /**
     * Get font weight options
     *
     * @return array Font weight options
     */
    public function get_font_weight_options() {
        return array(
            '300' => __('Light', 'custom-header-banner'),
            '400' => __('Regular', 'custom-header-banner'),
            '500' => __('Medium', 'custom-header-banner'),
            '600' => __('Semi-Bold', 'custom-header-banner'),
            '700' => __('Bold', 'custom-header-banner'),
            '800' => __('Extra Bold', 'custom-header-banner'),
        );
    }

    /**
     * Get animation type options
     *
     * @return array Animation type options
     */
    public function get_animation_type_options() {
        return array(
            'slide' => __('Slide', 'custom-header-banner'),
            'fade' => __('Fade', 'custom-header-banner'),
        );
    }

    /**
     * Get yes/no options
     *
     * @return array Yes/no options
     */
    public function get_yes_no_options() {
        return array(
            'yes' => __('Yes', 'custom-header-banner'),
            'no' => __('No', 'custom-header-banner'),
        );
    }
}
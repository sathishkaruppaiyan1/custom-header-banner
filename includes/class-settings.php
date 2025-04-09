<?php
/**
 * Settings class for Custom Header Banner
 *
 * @package Custom_Header_Banner
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Settings class
 */
class CHB_Settings {

    /**
     * Constructor
     */
    public function __construct() {
        // Register settings
        add_action('admin_init', array($this, 'register_settings'));
    }

    /**
     * Register plugin settings
     */
    public function register_settings() {
        // General settings
        register_setting('chb_options_group', 'chb_banner_type');
        register_setting('chb_options_group', 'chb_background_color');
        register_setting('chb_options_group', 'chb_text_color');
        register_setting('chb_options_group', 'chb_font_size', array('sanitize_callback' => 'absint'));
        register_setting('chb_options_group', 'chb_font_weight');
        
        // Marquee settings
        register_setting('chb_options_group', 'chb_marquee_text');
        
        // Slider settings
        register_setting('chb_options_group', 'chb_animation_type');
        register_setting('chb_options_group', 'chb_slider_speed', array('sanitize_callback' => 'absint'));
        register_setting('chb_options_group', 'chb_show_arrows');
        
        // Slider text and links
        register_setting('chb_options_group', 'chb_slider_text_1');
        register_setting('chb_options_group', 'chb_slider_text_2');
        register_setting('chb_options_group', 'chb_slider_text_3');
        register_setting('chb_options_group', 'chb_slider_link_1', array('sanitize_callback' => 'esc_url_raw'));
        register_setting('chb_options_group', 'chb_slider_link_2', array('sanitize_callback' => 'esc_url_raw'));
        register_setting('chb_options_group', 'chb_slider_link_3', array('sanitize_callback' => 'esc_url_raw'));
        
        // Active tab tracking
        register_setting('chb_options_group', 'chb_active_tab');
    }

    /**
     * Get setting value with default
     *
     * @param string $key     Setting key
     * @param mixed  $default Default value
     *
     * @return mixed Setting value
     */
    public function get_setting($key, $default = '') {
        return get_option($key, $default);
    }

    /**
     * Update setting
     *
     * @param string $key   Setting key
     * @param mixed  $value Setting value
     *
     * @return bool Whether the option was updated
     */
    public function update_setting($key, $value) {
        return update_option($key, $value);
    }

    /**
     * Delete setting
     *
     * @param string $key Setting key
     *
     * @return bool Whether the option was deleted
     */
    public function delete_setting($key) {
        return delete_option($key);
    }
}
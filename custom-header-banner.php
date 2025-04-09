<?php
/**
 * Plugin Name: Custom Header Banner for WooCommerce
 * Plugin URI: https://sathishkaruppaiyan.in
 * Description: Adds a customizable header banner with marquee/slider options for WooCommerce stores
 * Version: 1.1.0
 * Author: Sathish
 * Author URI: https://sathishkaruppaiyan.in
 * Text Domain: custom-header-banner
 * Requires at least: 5.0
 * Requires PHP: 7.2
 * WC requires at least: 3.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('CHB_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CHB_PLUGIN_URL', plugin_dir_url(__FILE__));
define('CHB_PLUGIN_VERSION', '1.1.0');
define('CHB_PLUGIN_FILE', __FILE__);

// Include required files
require_once CHB_PLUGIN_DIR . 'includes/class-settings.php';
require_once CHB_PLUGIN_DIR . 'includes/class-assets.php';
require_once CHB_PLUGIN_DIR . 'includes/class-admin.php';
require_once CHB_PLUGIN_DIR . 'includes/class-frontend.php';

/**
 * Main plugin class
 */
class Custom_Header_Banner {
    /**
     * Plugin instance
     *
     * @var Custom_Header_Banner
     */
    private static $instance = null;

    /**
     * Settings instance
     *
     * @var CHB_Settings
     */
    public $settings;

    /**
     * Assets instance
     *
     * @var CHB_Assets
     */
    public $assets;

    /**
     * Admin instance
     *
     * @var CHB_Admin
     */
    public $admin;

    /**
     * Frontend instance
     *
     * @var CHB_Frontend
     */
    public $frontend;

    /**
     * Constructor
     */
    private function __construct() {
        // Initialize plugin components
        $this->settings = new CHB_Settings();
        $this->assets = new CHB_Assets();
        $this->admin = new CHB_Admin();
        $this->frontend = new CHB_Frontend();
        
        // Register activation/deactivation hooks
        register_activation_hook(CHB_PLUGIN_FILE, array($this, 'activate'));
        register_deactivation_hook(CHB_PLUGIN_FILE, array($this, 'deactivate'));
        
        // Load text domain
        add_action('plugins_loaded', array($this, 'load_textdomain'));
    }

    /**
     * Get plugin instance
     * 
     * @return Custom_Header_Banner
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Plugin activation
     */
    public function activate() {
        // Create required directories
        $this->create_directories();
        
        // Create default asset files
        $this->create_default_assets();
        
        // Set default options
        $this->set_default_options();
        
        // Flush rewrite rules
        flush_rewrite_rules();
    }

    /**
     * Plugin deactivation
     */
    public function deactivate() {
        // Flush rewrite rules
        flush_rewrite_rules();
    }
    
    /**
     * Load plugin text domain
     */
    public function load_textdomain() {
        load_plugin_textdomain('custom-header-banner', false, dirname(plugin_basename(CHB_PLUGIN_FILE)) . '/languages');
    }
    
    /**
     * Create required directories
     */
    private function create_directories() {
        $dirs = array(
            CHB_PLUGIN_DIR . 'assets',
            CHB_PLUGIN_DIR . 'assets/css',
            CHB_PLUGIN_DIR . 'assets/js',
            CHB_PLUGIN_DIR . 'assets/images',
            CHB_PLUGIN_DIR . 'languages'
        );
        
        foreach ($dirs as $dir) {
            if (!file_exists($dir)) {
                wp_mkdir_p($dir);
            }
        }
    }
    
    /**
     * Create default asset files
     */
    private function create_default_assets() {
        // Create default CSS files
        $frontend_css = CHB_PLUGIN_DIR . 'assets/css/frontend.css';
        if (!file_exists($frontend_css)) {
            $css_content = '/* Custom Header Banner Frontend Styles */
.chb-header-banner {
    font-size: 14px;
    font-weight: 600;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.chb-slide-content:hover {
    text-decoration: underline;
}

.chb-slide-content a:hover {
    text-decoration: underline;
}

.chb-slider-controls {
    position: absolute;
    top: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: space-between;
    pointer-events: none;
}

.chb-slider-arrow {
    cursor: pointer;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    pointer-events: auto;
    opacity: 0.7;
    transition: opacity 0.2s ease;
}

.chb-slider-arrow:hover {
    opacity: 1;
}';
            file_put_contents($frontend_css, $css_content);
        }
        
        $admin_css = CHB_PLUGIN_DIR . 'assets/css/admin.css';
        if (!file_exists($admin_css)) {
            $admin_css_content = '/* Custom Header Banner Admin Styles */
.form-table th {
    width: 200px;
}

.slider-field p.description {
    margin-top: 5px;
    font-style: italic;
}

.chb-admin-header {
    background: #fff;
    border: 1px solid #ccd0d4;
    border-radius: 4px;
    padding: 15px 20px;
    margin: 20px 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.chb-admin-header h1 {
    margin: 0;
    padding: 0;
}

.chb-admin-tabs {
    margin-bottom: 20px;
}

.chb-admin-tabs .nav-tab {
    cursor: pointer;
}

.chb-admin-section {
    display: none;
}

.chb-admin-section.active {
    display: block;
}

.chb-preview {
    background: #f5f5f5;
    border: 1px solid #ddd;
    padding: 20px;
    margin-top: 20px;
    border-radius: 4px;
}';
            file_put_contents($admin_css, $admin_css_content);
        }
        
        // Create JS files
        $frontend_js = CHB_PLUGIN_DIR . 'assets/js/frontend.js';
        if (!file_exists($frontend_js)) {
            $js_content = '/* Custom Header Banner Frontend Scripts */
(function($) {
    "use strict";
    
    $(document).ready(function() {
        // Slider functionality
        const sliderInit = function() {
            var slides = $(".chb-slide");
            var currentSlide = 0;
            var animationType = chbSettings.animationType;
            var sliderSpeed = chbSettings.sliderSpeed;
            
            if (slides.length > 1) {
                // Auto rotation
                var sliderInterval = setInterval(function() {
                    nextSlide();
                }, sliderSpeed);
                
                // Manual navigation
                $(".chb-slider-prev").on("click", function(e) {
                    e.preventDefault();
                    clearInterval(sliderInterval);
                    prevSlide();
                    sliderInterval = setInterval(function() {
                        nextSlide();
                    }, sliderSpeed);
                });
                
                $(".chb-slider-next").on("click", function(e) {
                    e.preventDefault();
                    clearInterval(sliderInterval);
                    nextSlide();
                    sliderInterval = setInterval(function() {
                        nextSlide();
                    }, sliderSpeed);
                });
                
                function nextSlide() {
                    // Store previous slide
                    var previousSlide = currentSlide;
                    
                    // Remove active class from current slide
                    slides.eq(currentSlide).removeClass("active");
                    
                    // For slide animation, mark the previous slide
                    if (animationType === "slide") {
                        slides.eq(currentSlide).addClass("previous");
                        setTimeout(function() {
                            slides.eq(previousSlide).removeClass("previous");
                        }, 500);
                    }
                    
                    // Move to next slide
                    currentSlide = (currentSlide + 1) % slides.length;
                    
                    // Add active class to new current slide
                    slides.eq(currentSlide).addClass("active");
                }
                
                function prevSlide() {
                    // Remove active class from current slide
                    slides.eq(currentSlide).removeClass("active");
                    
                    // Move to previous slide
                    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
                    
                    // Add active class to new current slide
                    slides.eq(currentSlide).addClass("active");
                }
            }
        };
        
        // Initialize slider if it exists
        if ($(".chb-slider").length) {
            sliderInit();
        }
    });
    
})(jQuery);';
            file_put_contents($frontend_js, $js_content);
        }
        
        $admin_js = CHB_PLUGIN_DIR . 'assets/js/admin.js';
        if (!file_exists($admin_js)) {
            $admin_js_content = '/* Custom Header Banner Admin Scripts */
(function($) {
    "use strict";
    
    $(document).ready(function() {
        // Initialize color pickers
        $("input[type=\'color\']").wpColorPicker();
        
        // Tab navigation
        $(".chb-admin-tabs .nav-tab").on("click", function(e) {
            e.preventDefault();
            
            // Get the target section
            var target = $(this).data("tab");
            
            // Remove active class from all tabs and sections
            $(".chb-admin-tabs .nav-tab").removeClass("nav-tab-active");
            $(".chb-admin-section").removeClass("active");
            
            // Add active class to clicked tab and target section
            $(this).addClass("nav-tab-active");
            $("#" + target).addClass("active");
            
            // Update hidden input
            $("#chb_active_tab").val(target);
        });
        
        // Show active tab on load
        var activeTab = $("#chb_active_tab").val() || "general";
        $(".chb-admin-tabs .nav-tab[data-tab=\'" + activeTab + "\']").trigger("click");
        
        // Toggle fields based on banner type
        function toggleFields() {
            var bannerType = $("select[name=\'chb_banner_type\']").val();
            
            if (bannerType === "marquee") {
                $(".marquee-field").show();
                $(".slider-field").hide();
            } else {
                $(".marquee-field").hide();
                $(".slider-field").show();
            }
        }
        
        // Initial toggle on page load
        toggleFields();
        
        // Toggle on banner type change
        $("select[name=\'chb_banner_type\']").on("change", function() {
            toggleFields();
        });
        
        // Live preview update
        function updatePreview() {
            var bgColor = $("input[name=\'chb_background_color\']").val();
            var textColor = $("input[name=\'chb_text_color\']").val();
            var fontSize = $("input[name=\'chb_font_size\']").val() + "px";
            var fontWeight = $("select[name=\'chb_font_weight\']").val();
            
            $(".chb-preview-banner").css({
                "background-color": bgColor,
                "color": textColor,
                "font-size": fontSize,
                "font-weight": fontWeight
            });
        }
        
        // Initial preview
        updatePreview();
        
        // Update preview on change
        $("input[name=\'chb_background_color\'], input[name=\'chb_text_color\'], input[name=\'chb_font_size\'], select[name=\'chb_font_weight\']").on("change", function() {
            updatePreview();
        });
    });
    
})(jQuery);';
            file_put_contents($admin_js, $admin_js_content);
        }
        
        // Create arrow SVGs
        $arrow_left = CHB_PLUGIN_DIR . 'assets/images/arrow-left.svg';
        if (!file_exists($arrow_left)) {
            $svg_content = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>';
            file_put_contents($arrow_left, $svg_content);
        }
        
        $arrow_right = CHB_PLUGIN_DIR . 'assets/images/arrow-right.svg';
        if (!file_exists($arrow_right)) {
            $svg_content = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>';
            file_put_contents($arrow_right, $svg_content);
        }
    }
    
    /**
     * Set default options
     */
    private function set_default_options() {
        // General settings
        if (!get_option('chb_banner_type')) update_option('chb_banner_type', 'marquee');
        if (!get_option('chb_background_color')) update_option('chb_background_color', '#000000');
        if (!get_option('chb_text_color')) update_option('chb_text_color', '#ffffff');
        if (!get_option('chb_font_size')) update_option('chb_font_size', '14');
        if (!get_option('chb_font_weight')) update_option('chb_font_weight', '600');
        
        // Marquee settings
        if (!get_option('chb_marquee_text')) update_option('chb_marquee_text', 'Welcome to our shop!');
        
        // Slider settings
        if (!get_option('chb_animation_type')) update_option('chb_animation_type', 'slide');
        if (!get_option('chb_slider_speed')) update_option('chb_slider_speed', 3);
        if (!get_option('chb_show_arrows')) update_option('chb_show_arrows', 'yes');
    }
}

// Initialize the plugin
function chb_init() {
    return Custom_Header_Banner::get_instance();
}

// Global for backwards compatibility
$GLOBALS['custom_header_banner'] = chb_init();
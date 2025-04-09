<?php
/**
 * Admin page template
 *
 * @package Custom_Header_Banner
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="wrap">
    <div class="chb-admin-header">
        <h1><?php echo esc_html__('Custom Header Banner Settings', 'custom-header-banner'); ?></h1>
        <div class="chb-admin-version">
            <?php echo esc_html__('Version', 'custom-header-banner'); ?>: <?php echo esc_html(CHB_PLUGIN_VERSION); ?>
        </div>
    </div>
    
    <h2 class="chb-admin-tabs nav-tab-wrapper">
        <a href="#" class="nav-tab <?php echo $active_tab === 'general' ? 'nav-tab-active' : ''; ?>" data-tab="general">
            <?php echo esc_html__('General', 'custom-header-banner'); ?>
        </a>
        <a href="#" class="nav-tab <?php echo $active_tab === 'marquee' ? 'nav-tab-active' : ''; ?>" data-tab="marquee">
            <?php echo esc_html__('Marquee Settings', 'custom-header-banner'); ?>
        </a>
        <a href="#" class="nav-tab <?php echo $active_tab === 'slider' ? 'nav-tab-active' : ''; ?>" data-tab="slider">
            <?php echo esc_html__('Slider Settings', 'custom-header-banner'); ?>
        </a>
    </h2>
    
    <form method="post" action="options.php">
        <?php settings_fields('chb_options_group'); ?>
        <?php do_settings_sections('chb_options_group'); ?>
        
        <input type="hidden" name="chb_active_tab" id="chb_active_tab" value="<?php echo esc_attr($active_tab); ?>">
        
        <!-- General Settings Section -->
        <div id="general" class="chb-admin-section <?php echo $active_tab === 'general' ? 'active' : ''; ?>">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php echo esc_html__('Banner Type', 'custom-header-banner'); ?></th>
                    <td>
                        <select name="chb_banner_type">
                            <option value="marquee" <?php selected($settings->get_setting('chb_banner_type'), 'marquee'); ?>>
                                <?php echo esc_html__('Marquee (Continuous Scrolling)', 'custom-header-banner'); ?>
                            </option>
                            <option value="slider" <?php selected($settings->get_setting('chb_banner_type'), 'slider'); ?>>
                                <?php echo esc_html__('Slider (Multiple Slides)', 'custom-header-banner'); ?>
                            </option>
                        </select>
                    </td>
                </tr>
                
                <tr valign="top">
                    <th scope="row"><?php echo esc_html__('Background Color', 'custom-header-banner'); ?></th>
                    <td>
                        <input type="color" name="chb_background_color" value="<?php echo esc_attr($settings->get_setting('chb_background_color', '#000000')); ?>" />
                    </td>
                </tr>
                
                <tr valign="top">
                    <th scope="row"><?php echo esc_html__('Text Color', 'custom-header-banner'); ?></th>
                    <td>
                        <input type="color" name="chb_text_color" value="<?php echo esc_attr($settings->get_setting('chb_text_color', '#ffffff')); ?>" />
                    </td>
                </tr>
                
                <tr valign="top">
                    <th scope="row"><?php echo esc_html__('Font Size (px)', 'custom-header-banner'); ?></th>
                    <td>
                        <input type="number" name="chb_font_size" value="<?php echo esc_attr($settings->get_setting('chb_font_size', '14')); ?>" min="10" max="24" />
                        <p class="description"><?php echo esc_html__('Size of the banner text in pixels', 'custom-header-banner'); ?></p>
                    </td>
                </tr>
                
                <tr valign="top">
                    <th scope="row"><?php echo esc_html__('Font Weight', 'custom-header-banner'); ?></th>
                    <td>
                        <select name="chb_font_weight">
                            <?php foreach (chb_init()->admin->get_font_weight_options() as $value => $label) : ?>
                                <option value="<?php echo esc_attr($value); ?>" <?php selected($settings->get_setting('chb_font_weight'), $value); ?>>
                                    <?php echo esc_html($label); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
            </table>

            <div class="chb-preview">
                <h3><?php echo esc_html__('Preview', 'custom-header-banner'); ?></h3>
                <div class="chb-preview-banner">
                    <?php echo esc_html__('This is how your banner styling will look', 'custom-header-banner'); ?>
                </div>
            </div>
        </div>
        
        <!-- Marquee Settings Section -->
        <div id="marquee" class="chb-admin-section <?php echo $active_tab === 'marquee' ? 'active' : ''; ?>">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php echo esc_html__('Marquee Text', 'custom-header-banner'); ?></th>
                    <td>
                        <textarea name="chb_marquee_text" rows="3" cols="50"><?php echo esc_textarea($settings->get_setting('chb_marquee_text')); ?></textarea>
                        <p class="description"><?php echo esc_html__('Text that will continuously scroll in the banner', 'custom-header-banner'); ?></p>
                    </td>
                </tr>
            </table>
        </div>
        
        <!-- Slider Settings Section -->
        <div id="slider" class="chb-admin-section <?php echo $active_tab === 'slider' ? 'active' : ''; ?>">
            <table class="form-table">
                <!-- Animation Type -->
                <tr valign="top">
                    <th scope="row"><?php echo esc_html__('Animation Type', 'custom-header-banner'); ?></th>
                    <td>
                        <select name="chb_animation_type">
                            <?php foreach (chb_init()->admin->get_animation_type_options() as $value => $label) : ?>
                                <option value="<?php echo esc_attr($value); ?>" <?php selected($settings->get_setting('chb_animation_type'), $value); ?>>
                                    <?php echo esc_html($label); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                
                <tr valign="top">
                    <th scope="row"><?php echo esc_html__('Show Navigation Arrows', 'custom-header-banner'); ?></th>
                    <td>
                        <select name="chb_show_arrows">
                            <?php foreach (chb_init()->admin->get_yes_no_options() as $value => $label) : ?>
                                <option value="<?php echo esc_attr($value); ?>" <?php selected($settings->get_setting('chb_show_arrows'), $value); ?>>
                                    <?php echo esc_html($label); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                
                <tr valign="top">
                    <th scope="row"><?php echo esc_html__('Slider Speed (seconds)', 'custom-header-banner'); ?></th>
                    <td>
                        <input type="number" name="chb_slider_speed" value="<?php echo esc_attr($settings->get_setting('chb_slider_speed', 3)); ?>" min="1" max="10" />
                    </td>
                </tr>
                
                <!-- Slider Text 1 -->
                <tr valign="top">
                    <th scope="row"><?php echo esc_html__('Slider Text 1', 'custom-header-banner'); ?></th>
                    <td>
                        <input type="text" name="chb_slider_text_1" value="<?php echo esc_attr($settings->get_setting('chb_slider_text_1')); ?>" class="regular-text" />
                        <p class="description"><?php echo esc_html__('Enter the text for the first slide', 'custom-header-banner'); ?></p>
                    </td>
                </tr>
                
                <!-- Slider Link 1 -->
                <tr valign="top">
                    <th scope="row"><?php echo esc_html__('Slider Link 1', 'custom-header-banner'); ?></th>
                    <td>
                        <input type="url" name="chb_slider_link_1" value="<?php echo esc_url($settings->get_setting('chb_slider_link_1')); ?>" class="regular-text" />
                        <p class="description"><?php echo esc_html__('Enter the URL for the first slide (leave empty for no link)', 'custom-header-banner'); ?></p>
                    </td>
                </tr>
                
                <!-- Slider Text 2 -->
                <tr valign="top">
                    <th scope="row"><?php echo esc_html__('Slider Text 2', 'custom-header-banner'); ?></th>
                    <td>
                        <input type="text" name="chb_slider_text_2" value="<?php echo esc_attr($settings->get_setting('chb_slider_text_2')); ?>" class="regular-text" />
                        <p class="description"><?php echo esc_html__('Enter the text for the second slide', 'custom-header-banner'); ?></p>
                    </td>
                </tr>
                
                <!-- Slider Link 2 -->
                <tr valign="top">
                    <th scope="row"><?php echo esc_html__('Slider Link 2', 'custom-header-banner'); ?></th>
                    <td>
                        <input type="url" name="chb_slider_link_2" value="<?php echo esc_url($settings->get_setting('chb_slider_link_2')); ?>" class="regular-text" />
                        <p class="description"><?php echo esc_html__('Enter the URL for the second slide (leave empty for no link)', 'custom-header-banner'); ?></p>
                    </td>
                </tr>
                
                <!-- Slider Text 3 -->
                <tr valign="top">
                    <th scope="row"><?php echo esc_html__('Slider Text 3', 'custom-header-banner'); ?></th>
                    <td>
                        <input type="text" name="chb_slider_text_3" value="<?php echo esc_attr($settings->get_setting('chb_slider_text_3')); ?>" class="regular-text" />
                        <p class="description"><?php echo esc_html__('Enter the text for the third slide', 'custom-header-banner'); ?></p>
                    </td>
                </tr>
                
                <!-- Slider Link 3 -->
                <tr valign="top">
                    <th scope="row"><?php echo esc_html__('Slider Link 3', 'custom-header-banner'); ?></th>
                    <td>
                        <input type="url" name="chb_slider_link_3" value="<?php echo esc_url($settings->get_setting('chb_slider_link_3')); ?>" class="regular-text" />
                        <p class="description"><?php echo esc_html__('Enter the URL for the third slide (leave empty for no link)', 'custom-header-banner'); ?></p>
                    </td>
                </tr>
            </table>
        </div>
        
        <?php submit_button(); ?>
    </form>
</div>
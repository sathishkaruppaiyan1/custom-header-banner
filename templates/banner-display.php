<?php
/**
 * Header banner display template
 *
 * @package Custom_Header_Banner
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Additional CSS styles
?>
<style>
    .chb-header-banner {
        background-color: <?php echo esc_attr($bg_color); ?>;
        color: <?php echo esc_attr($text_color); ?>;
        padding: 10px 0;
        text-align: center;
        width: 100%;
        position: relative;
        z-index: 999;
        font-size: <?php echo esc_attr($font_size); ?>px;
        font-weight: <?php echo esc_attr($font_weight); ?>;
    }
    
    .chb-marquee {
        white-space: nowrap;
        overflow: hidden;
    }
    
    .chb-marquee-content {
        display: inline-block;
        padding-left: 100%;
        animation: chb-marquee 20s linear infinite;
    }
    
    @keyframes chb-marquee {
        0% { transform: translate(0, 0); }
        100% { transform: translate(-100%, 0); }
    }
    
    .chb-slider {
        position: relative;
        height: <?php echo (intval($font_size) + 12); ?>px;
        overflow: hidden;
    }
    
    .chb-slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .chb-slide.active {
        opacity: 1;
    }
    
    .chb-slide-content {
        display: inline-flex;
        align-items: center;
        cursor: pointer;
        position: relative;
        padding: 0 5px;
        width: 100%;
        justify-content: center;
    }
    
    .chb-slide-content a {
        display: inline-flex;
        align-items: center;
        color: <?php echo esc_attr($text_color); ?>;
        text-decoration: none;
    }
    
    .chb-corner-icon {
        width: 8px;
        height: 8px;
        position: absolute;
        border: 2px solid <?php echo esc_attr($text_color); ?>;
    }
    
    .chb-corner-top-left {
        top: -6px;
        left: 5px;
        border-right: 0;
        border-bottom: 0;
    }
    
    .chb-corner-top-right {
        top: -6px;
        right: 5px;
        border-left: 0;
        border-bottom: 0;
    }
    
    .chb-corner-bottom-left {
        bottom: -6px;
        left: 5px;
        border-right: 0;
        border-top: 0;
    }
    
    .chb-corner-bottom-right {
        bottom: -6px;
        right: 5px;
        border-left: 0;
        border-top: 0;
    }
    
    /* Fade animation specific styles */
    .chb-animation-fade .chb-slide {
        transition: opacity 0.8s ease-in-out;
    }
    
    /* Slide animation specific styles */
    .chb-animation-slide .chb-slide {
        transition: transform 0.5s ease-in-out, opacity 0.3s ease-in-out;
        transform: translateX(100%);
    }
    
    .chb-animation-slide .chb-slide.active {
        transform: translateX(0);
    }
    
    .chb-animation-slide .chb-slide.previous {
        transform: translateX(-100%);
    }
    
    /* Slider controls */
    .chb-slider-controls {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
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
        z-index: 10;
        color: <?php echo esc_attr($text_color); ?>;
    }
    
    .chb-slider-prev {
        margin-left: 5px;
    }
    
    .chb-slider-next {
        margin-right: 5px;
    }
    
    .chb-slider-arrow:hover {
        opacity: 1;
    }
</style>

<!-- Banner HTML -->
<div class="chb-header-banner">
    <?php if ($banner_type === 'marquee') : ?>
        <?php $marquee_text = $settings->get_setting('chb_marquee_text', ''); ?>
        
        <?php if (!empty($marquee_text)) : ?>
            <div class="chb-marquee">
                <div class="chb-marquee-content"><?php echo esc_html($marquee_text); ?></div>
            </div>
        <?php endif; ?>
    <?php else : ?>
        <?php
        $slider_text_1 = $settings->get_setting('chb_slider_text_1', '');
        $slider_text_2 = $settings->get_setting('chb_slider_text_2', '');
        $slider_text_3 = $settings->get_setting('chb_slider_text_3', '');
        
        $slider_link_1 = $settings->get_setting('chb_slider_link_1', '');
        $slider_link_2 = $settings->get_setting('chb_slider_link_2', '');
        $slider_link_3 = $settings->get_setting('chb_slider_link_3', '');
        
        $has_slides = !empty($slider_text_1) || !empty($slider_text_2) || !empty($slider_text_3);
        ?>
        
        <?php if ($has_slides) : ?>
            <div class="chb-slider chb-animation-<?php echo esc_attr($animation_type); ?>">
                <?php if (!empty($slider_text_1)) : ?>
                    <div class="chb-slide active">
                        <?php if (!empty($slider_link_1)) : ?>
                            <div class="chb-slide-content">
                                <span class="chb-corner-icon chb-corner-top-left"></span>
                                <span class="chb-corner-icon chb-corner-top-right"></span>
                                <span class="chb-corner-icon chb-corner-bottom-left"></span>
                                <span class="chb-corner-icon chb-corner-bottom-right"></span>
                                <a href="<?php echo esc_url($slider_link_1); ?>"><?php echo esc_html($slider_text_1); ?></a>
                            </div>
                        <?php else : ?>
                            <div class="chb-slide-content">
                                <span class="chb-corner-icon chb-corner-top-left"></span>
                                <span class="chb-corner-icon chb-corner-top-right"></span>
                                <span class="chb-corner-icon chb-corner-bottom-left"></span>
                                <span class="chb-corner-icon chb-corner-bottom-right"></span>
                                <?php echo esc_html($slider_text_1); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($slider_text_2)) : ?>
                    <div class="chb-slide">
                        <?php if (!empty($slider_link_2)) : ?>
                            <div class="chb-slide-content">
                                <span class="chb-corner-icon chb-corner-top-left"></span>
                                <span class="chb-corner-icon chb-corner-top-right"></span>
                                <span class="chb-corner-icon chb-corner-bottom-left"></span>
                                <span class="chb-corner-icon chb-corner-bottom-right"></span>
                                <a href="<?php echo esc_url($slider_link_2); ?>"><?php echo esc_html($slider_text_2); ?></a>
                            </div>
                        <?php else : ?>
                            <div class="chb-slide-content">
                                <span class="chb-corner-icon chb-corner-top-left"></span>
                                <span class="chb-corner-icon chb-corner-top-right"></span>
                                <span class="chb-corner-icon chb-corner-bottom-left"></span>
                                <span class="chb-corner-icon chb-corner-bottom-right"></span>
                                <?php echo esc_html($slider_text_2); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($slider_text_3)) : ?>
                    <div class="chb-slide">
                        <?php if (!empty($slider_link_3)) : ?>
                            <div class="chb-slide-content">
                                <span class="chb-corner-icon chb-corner-top-left"></span>
                                <span class="chb-corner-icon chb-corner-top-right"></span>
                                <span class="chb-corner-icon chb-corner-bottom-left"></span>
                                <span class="chb-corner-icon chb-corner-bottom-right"></span>
                                <a href="<?php echo esc_url($slider_link_3); ?>"><?php echo esc_html($slider_text_3); ?></a>
                            </div>
                        <?php else : ?>
                            <div class="chb-slide-content">
                                <span class="chb-corner-icon chb-corner-top-left"></span>
                                <span class="chb-corner-icon chb-corner-top-right"></span>
                                <span class="chb-corner-icon chb-corner-bottom-left"></span>
                                <span class="chb-corner-icon chb-corner-bottom-right"></span>
                                <?php echo esc_html($slider_text_3); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($show_arrows === 'yes' && count(array_filter([$slider_text_1, $slider_text_2, $slider_text_3])) > 1) : ?>
                <div class="chb-slider-controls">
                    <div class="chb-slider-arrow chb-slider-prev">
                        <?php echo $assets->get_svg('arrow-left'); ?>
                    </div>
                    <div class="chb-slider-arrow chb-slider-next">
                        <?php echo $assets->get_svg('arrow-right'); ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
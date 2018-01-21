<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// override slider theme
//require_once get_stylesheet_directory() .'/libs/css_js_include.php';
require_once get_stylesheet_directory() .'/libs/listing_functions.php';
require_once get_stylesheet_directory() .'/libs/ajax_functions.php';
require_once get_stylesheet_directory() .'/libs/theme-slider.php';
require_once get_stylesheet_directory() .'/libs/help_functions.php';
// require_once get_stylesheet_directory() .'/libs/property.php';
require_once get_stylesheet_directory() .'/libs/shortcodes.php';


// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_parent_css' ) ):
    function chld_thm_cfg_parent_css() {
        wp_enqueue_style('wpestate_bootstrap',get_template_directory_uri().'/css/bootstrap.css', array(), '1.0', 'all');
        wp_enqueue_style('wpestate_bootstrap-theme',get_template_directory_uri().'/css/bootstrap-theme.css', array(), '1.0', 'all');
        wp_enqueue_style( 'chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css' );
        wp_enqueue_style('wpestate_media',get_template_directory_uri().'/css/my_media.css', array(), '1.0', 'all');
    }
endif;
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css' );

/**
 * Enqueue scripts and styles.
 */
/*function onetyone_scripts() {
	if(is_page(245))
	{
		wp_enqueue_script( 'map-script', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDnd-0EAv65fAFfzlflgqAd23n9IDmEmqA', array(), null, true );
		wp_enqueue_script( 'map-js-script', get_template_directory_uri() . '/js/map-min.js', array(), null, true );
	}
}
add_action( 'wp_enqueue_scripts', 'onetyone_scripts' );*/

// END ENQUEUE PARENT ACTION

// exclude properties from blog search results
add_action( 'init', 'update_estate_property_post_type', 99 );

function update_estate_property_post_type() {
    global $wp_post_types;
    if ( post_type_exists( 'estate_property' ) ) {
        // exclude from search results
        $wp_post_types['estate_property']->exclude_from_search = true;
    }
}

/**
 * Enqueue scripts and styles.
 */
function onetyone_scripts() {
     wp_enqueue_script('wpestate_ajaxcalls', '/wp-content/themes/onetyone'.'/js/ajaxcalls.js',array('jquery'), '1.0', true);
     wp_enqueue_script('wpestate_property', '/wp-content/themes/onetyone'.'/js/property.js',array('jquery'), '1.0', true);
    if(is_page(2081) || is_page(254))
    {
        // wp_enqueue_script( 'map-script', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBN2tzJmAQ_r3QTeWKT23Mw3rB-v5Y5zBU', array(), null, true );
        wp_enqueue_script( 'map-js-script', '/wp-content/themes/onetyone' . '/js/map.js', array(), null, true );
    }
}
add_action( 'wp_enqueue_scripts', 'onetyone_scripts' );

/**
 * Register our sidebars and widgetized areas.
 *
 */
function arphabet_widgets_init() {

    register_sidebar(array(
        'name' => esc_html__( 'Property side bar', 'wpestate'),
        'id' => 'property_side_bar',
        'description' => esc_html__( 'Property side bar widget area', 'wpestate'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title-sidebar">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => esc_html__( 'Blog side bar', 'wpestate'),
        'id' => 'blog_side_bar',
        'description' => esc_html__( 'Blog side bar widget area', 'wpestate'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title-sidebar">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => esc_html__( 'Blog Post side bar', 'wpestate'),
        'id' => 'blog_post_side_bar',
        'description' => esc_html__( 'Blog Post side bar widget area', 'wpestate'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title-sidebar">',
        'after_title' => '</h3>',
    ));

}
add_action( 'widgets_init', 'arphabet_widgets_init' );

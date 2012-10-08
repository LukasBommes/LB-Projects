<?php
/*
*
*	functions.php
*
*	LB-Projects Theme
*	Author: Lukas Bommes
*	Copyright (C) Lukas Bommes
*
*/

// Define basic theme settings and features
function LB_theme_setup() {

	// Fallback for content width
	if( !isset( $content_width ) ) $content_width = 678;

	// Support specific theme functions
	add_theme_support('automatic-feed-links');
	add_theme_support('post-thumbnails');
	add_editor_style();
	
	// Register navigation menus
	register_nav_menu('header', __('Header-Navigation', 'lbprojects'));
	register_nav_menu('footer', __('Footer-Navigation', 'lbprojects'));
	
	// Add support for post formats
	add_theme_support('post-formats', array( 'image', 'aside', 'quote' ));
	
}
add_action('after_setup_theme', 'LB_theme_setup');


// Redirect user to options page after activation
if( is_admin() && isset( $_GET['activated'] ) && $pagenow =="themes.php" ) {
	wp_redirect('themes.php?page=options-framework');
}


// Add textdomain for tranlation
load_theme_textdomain('lbprojects', get_template_directory() . '/languages');


// Register sidebar widget areas
register_sidebar(array('name' => 'Sidebar', 'id' => 'sidebar', 'description' => __('The main sidebar widget area', 'lbprojects')));
register_sidebar(array('name' => 'Footer 1', 'id' => 'footer-widget1', 'description' => __('Optional widget area for the site footer', 'lbprojects'), 'before_widget' => '<li class="footer-widget">', 'after_widget' => '</li>'));
register_sidebar(array('name' => 'Footer 2', 'id' => 'footer-widget2', 'description' => __('Optional widget area for the site footer', 'lbprojects'), 'before_widget' => '<li class="footer-widget">', 'after_widget' => '</li>'));
register_sidebar(array('name' => 'Footer 3', 'id' => 'footer-widget3', 'description' => __('Optional widget area for the site footer', 'lbprojects'), 'before_widget' => '<li class="footer-widget">', 'after_widget' => '</li>'));
register_sidebar(array('name' => 'Footer 4', 'id' => 'footer-widget4', 'description' => __('Optional widget area for the site footer', 'lbprojects'), 'before_widget' => '<li class="footer-widget">', 'after_widget' => '</li>'));


// Register and add scripts
function LB_load_scripts() {

	// Add jQuery library from Google
	wp_deregister_script('jquery');
    wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js');
    wp_enqueue_script('jquery');

	// Miscellaneous scripts	
	wp_enqueue_script('scroll-top', get_template_directory_uri() . '/js/scroll-top.js');
	wp_enqueue_script('iframe-wmode', get_template_directory_uri() . '/js/iframe-wmode.js');
	wp_enqueue_script('defvalue-changer', get_template_directory_uri() . '/js/defvalue-changer.js');	
	wp_enqueue_script('twitter-widget', get_template_directory_uri() . '/js/twitter-widget.js');
	if( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );
	
	// Content Scripts (spoilers, boxes, etc.)
	wp_enqueue_script('jquery-cookie-plugin', get_template_directory_uri() . '/js/jquery-cookies.js');
	wp_enqueue_script('toggle-comment', get_template_directory_uri() . '/js/toggle-comment.js');
	wp_enqueue_script('toggle-boxes', get_template_directory_uri() . '/js/toggle-boxes.js');
	wp_enqueue_script('header-boxes', get_template_directory_uri() . '/js/header-boxes.js');
	
	// Superfish Navigation
	wp_enqueue_script('superfish', get_template_directory_uri() . '/navigation/superfish.js');
	wp_enqueue_script('superfish-hover', get_template_directory_uri() . '/navigation/hover-intent.js');
	wp_enqueue_script('superfish-supersubs', get_template_directory_uri() . '/navigation/supersubs.js');
	wp_enqueue_script('superfish-resizer', get_template_directory_uri() . '/navigation/navigation-resizer.js');
	
	// Slideshows
	wp_enqueue_script('s3Slider', get_template_directory_uri() . '/js/s3Slider.js');
	wp_enqueue_script('featured-slider', get_template_directory_uri() . '/js/featured-slider.js');
	
	// Lightbox Plugin
	wp_enqueue_script('lightbox-plugin', get_template_directory_uri() . '/lightbox/fancybox.js');
	wp_enqueue_script('lightbox-buttons', get_template_directory_uri() . '/lightbox/helpers/fancybox-buttons.js');
	wp_enqueue_script('lightbox-media', get_template_directory_uri() . '/lightbox/helpers/fancybox-media.js');
	wp_enqueue_script('lightbox-thumbs', get_template_directory_uri() . '/lightbox/helpers/fancybox-thumbs.js');	
	wp_enqueue_script('lightbox-mousewheel', get_template_directory_uri() . '/lightbox/fancybox-mousewheel.js');
	
	// Google Maps scripts
	wp_enqueue_script('googlemaps-load', get_template_directory_uri() . '/js/googlemaps-load.js');
	wp_enqueue_script('googlemaps-plugin', get_template_directory_uri() . '/js/googlemaps-plugin.js');
	
}
add_action( 'wp_enqueue_scripts', 'LB_load_scripts' );


// Register stylesheets
function LB_load_styles() {
	wp_enqueue_style('main-style', get_stylesheet_uri());
	wp_enqueue_style('contactform-style', get_template_directory_uri() . '/css/contactform.css');
	wp_enqueue_style('featured-slider-style', get_template_directory_uri() . '/css/featured-slider.css');
	wp_enqueue_style('s3Slider-style', get_template_directory_uri() . '/css/s3slider.css');
	wp_enqueue_style('superfish-style', get_template_directory_uri() . '/navigation/superfish.css');
	wp_enqueue_style('icon-font', get_template_directory_uri() . '/css/icon-font.css');
	
	// Lightbox Plugin
	wp_enqueue_style('lightbox-plugin-style', get_template_directory_uri() . '/lightbox/fancybox.css');
	wp_enqueue_style('lightbox-buttons-style', get_template_directory_uri() . '/lightbox/helpers/fancybox-buttons.css');
	wp_enqueue_style('lightbox-thumbs-style', get_template_directory_uri() . '/lightbox/helpers/fancybox-thumbs.css');
}
add_action( 'wp_enqueue_scripts', 'LB_load_styles' );


// Inculde outsourced code
require_once(get_template_directory() . '/functions/breadcrumb_functions.php');
require_once(get_template_directory() . '/functions/content_functions.php');
require_once(get_template_directory() . '/functions/custom_functions.php');
require_once(get_template_directory() . '/functions/shortcode_functions.php');
require_once(get_template_directory() . '/functions/featured_post_functions.php');
require_once(get_template_directory() . '/functions/like_system_functions.php');
require_once(get_template_directory() . '/functions/gallery_pagination.php');


// Include custom widgets
require_once(get_template_directory() . '/widgets/recentposts_widget.php');
require_once(get_template_directory() . '/widgets/tagcloud_widget.php');
require_once(get_template_directory() . '/widgets/about_widget.php');
require_once(get_template_directory() . '/widgets/gallery_widget.php');
require_once(get_template_directory() . '/widgets/twitter_widget.php');

function LB_load_widgets() {
	register_widget('LB_recent_posts_widget');
	register_widget('LB_tagcloud_widget');
	register_widget('LB_about_widget');
	register_widget('LB_random_images_widget');
	register_widget('LB_twitter_widget');
}
add_action( 'widgets_init', 'LB_load_widgets' );


// Include theme options panel
if( !function_exists('optionsframework_init') ) {
	define('OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/admin/');
	require_once(get_template_directory() . '/admin/options-framework.php');
	require_once(get_template_directory() . '/admin/options.php');
}


// Add custom gallery shortcode for pagination (gallery_pagination.php)
if( of_get_option('paginated_gallery') ) {
	remove_shortcode('gallery');
	add_shortcode('gallery', 'LB_paginated_gallery');
}

?>
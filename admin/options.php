<?php
/*
*
*	theme_options.php
*
*	LB-Projects Theme
*	Autor: Lukas Bommes
*	Copyright (C) Lukas Bommes
*
*/

// Store options in the database
function optionsframework_option_name() {
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );
	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

// Embed Google Webfonts
function options_typography_embed_google_fonts() {
	wp_enqueue_style( 'options_typography_Lato', 'http://fonts.googleapis.com/css?family=Lato' );
	wp_enqueue_style( 'options_typography_Nobile', 'http://fonts.googleapis.com/css?family=Nobile' );	
	wp_enqueue_style( 'options_typography_PT Sans', 'http://fonts.googleapis.com/css?family=PT Sans' );
}
add_action('wp_head', 'options_typography_embed_google_fonts');

// Theme-Options Array
function optionsframework_options() {

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';
	
	// Typography Options
	$typography_options = array(
		'sizes' => array( '12', '13', '14', '15' ),
		'faces' => array(
			'Arial, sans-serif' => 'Arial',
			'Verdana, sans-serif' => 'Verdana',
			'Lato, sans-serif' => 'Lato',
			'Nobile, sans-serif' => 'Nobile',
			'PT Sans, sans-serif' => 'PT Sans'
		),
		'styles' => array( 'normal' => __('Normal', 'lbprojects'), 'italic' => __('Italic', 'lbprojects') ),
		'color' => false
	);

	$options = array();

	// Basic Settings
	$options[] = array(
		'name' => __('Basic Settings', 'lbprojects'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Announcement Text', 'lbprojects'),
		'desc' => __('This text will be displayed on a yellow background. You can use it for important information or announcements to your readers.', 'lbprojects'),
		'id' => 'announcements',
		'std' => '',
		'type' => 'textarea');
		
	$options[] = array(
		'name' => __('Header Image', 'lbprojects'),
		'desc' => __('The header image should be 1000 pixels width and about 200 pixels height.', 'lbprojects'),
		'id' => 'header_image',
		'type' => 'upload');

	$options[] = array(
		'name' => __('Logo', 'lbprojects'),
		'desc' => __('For the best displaying results the logo should be 50 pixels width.', 'lbprojects'),
		'id' => 'logo',
		'type' => 'upload');

	$options[] = array(
		'name' => __('Favicon', 'lbprojects'),
		'desc' => __('A favicon is a 16x16 pixels width an height image in the ICO-format. This image will be shown in the browser\'s adress bar.', 'lbprojects'),
		'id' => 'favicon',
		'type' => 'upload');

	$options[] = array(
		'name' => __('Background', 'lbprojects'),
		'desc' => __('Change the site\'s background options.', 'lbprojects'),
		'id' => 'background',
		'std' => array( 'color' => '#efefef', 'image' => '', 'repeat' => 'repeat', 'position' => 'top center', 'attachment'=>'scroll' ),
		'type' => 'background');

	$options[] = array(
		'name' => __('Header Color', 'lbprojects'),
		'desc' => __('Select the Color of the Header.', 'lbprojects'),
		'id' => 'header_color',
		'std' => '#33363b',
		'type' => 'color' );

	$options[] = array(
		'name' => __('Footer Color', 'lbprojects'),
		'desc' => __('Select the Color of the Footer.', 'lbprojects'),
		'id' => 'footer_color',
		'std' => '#d54e21',
		'type' => 'color' );
		
	$options[] = array(
		'name' => __('Link Color', 'lbprojects'),
		'desc' => __('Select the Color of Links and all accents on the website.', 'lbprojects'),
		'id' => 'link_color',
		'std' => '#d54e21',
		'type' => 'color' );

	$options[] = array(
		'name' => __('Sidebar Position', 'lbprojects'),
		'desc' => __('Select the position of the sidebar.', 'lbprojects'),
		'id' => 'sidebar_position',
		'std' => 'right_sidebar',
		'type' => 'images',
		'options' => array( 'left_sidebar' => $imagepath . 'left_sidebar.png', 'right_sidebar' => $imagepath . 'right_sidebar.png' ) );
		
	$options[] = array(
		'name' => __('Header Scrolling Behaviour', 'lbprojects'),
		'desc' => __('Select the scrolling behaviour of the header.', 'lbprojects'),
		'id' => 'header_scroll',
		'std' => 'one',
		'type' => 'select',
		'options' => array( 'one' => __('Scroll with rest of page', 'lbprojects'), 'two' => __('Stick to top of browser window', 'lbprojects') ) );

	$options[] = array(
		'name' => __('Footer Copyright Text', 'lbprojects'),
		'desc' => __('Enter your custom footer text to display copyright information.', 'lbprojects'),
		'id' => 'footer_text',
		'std' => 'Copyright &copy; Lukas Bommes 2012',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Typography', 'lbprojects'),
		'desc' => __('Settings for font size, font face and font style.', 'lbprojects'),
		'id' => 'typography',
		'std' => array( 'size' => '12px', 'face' => 'Verdana', 'style' => 'normal', 'color' => '#3a3a3a' ),
		'type' => 'typography',
		'options' => $typography_options );

	// Advanced Settings
	$options[] = array(
		'name' => __('Advanced Settings', 'lbprojects'),
		'type' => 'heading');
		
	$options[] = array(
		'name' => __('Maintenance Mode', 'lbprojects'),
		'desc' => __('Activate the maintenance mode to only allow administrators to visit the website.', 'lbprojects'),
		'id' => 'maintenance_mode',
		'std' => '0',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Google Analytics Tracking', 'lbprojects'),
		'desc' => __('Enter your Google Analytics Account ID. For example: UA-123456-12', 'lbprojects'),
		'id' => 'ga_code',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Custom CSS', 'lbprojects'),
		'desc' => __('Here you can add custom properties to the stylesheet, e.g. .button{color:green;}. They will be automatically added to the website\'s header.', 'lbprojects'),
		'id' => 'custom_css',
		'std' => '',
		'type' => 'textarea');
		
	$options[] = array(
		'name' => __('External Links', 'lbprojects'),
		'desc' => __('Force browsers to open external links in new window or tab.', 'lbprojects'),
		'id' => 'external_links',
		'std' => '0',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Admin Style', 'lbprojects'),
		'desc' => __('Use the custom backend stylesheet.', 'lbprojects'),
		'id' => 'admin_style',
		'std' => '1',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Header Forms', 'lbprojects'),
		'desc' => __('Check the features you want to be displayed in the site\'s header.', 'lbprojects'),
		'id' => 'header_form',
		'std' => array( 'one' => '1', 'two' => '1'	),
		'type' => 'multicheck',
		'options' => array( 'one' => __('Login Form', 'lbprojects'), 'two' => __('Search Form', 'lbprojects') ) );

	$options[] = array(
		'name' => __('About the author Widget', 'lbprojects'),
		'desc' => __('Display a widget with the author meta after each post.', 'lbprojects'),
		'id' => 'show_author',
		'std' => '0',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Related Posts', 'lbprojects'),
		'desc' => __('Display related posts below each post.', 'lbprojects'),
		'id' => 'related_posts',
		'std' => '1',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Thumbnails', 'lbprojects'),
		'desc' => __('Display featured post thumbnails for each post on archive pages.', 'lbprojects'),
		'id' => 'thumbnails',
		'std' => '0',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Breadcrumb Navigation', 'lbprojects'),
		'desc' => __('Display the Breadcrumb-Navigation at the top of each page.', 'lbprojects'),
		'id' => 'breadcrumb',
		'std' => '1',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Scroll to Top Button', 'lbprojects'),
		'desc' => __('Display the Scroll to Top Button in the bottom right corner.', 'lbprojects'),
		'id' => 'scroll_button',
		'std' => '1',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Like Button', 'lbprojects'),
		'desc' => __('Display the like button for each post.', 'lbprojects'),
		'id' => 'like_button',
		'std' => '1',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Exclude Pages from Search', 'lbprojects'),
		'desc' => __('Check this option to exclude static pages from the site\'s search.', 'lbprojects'),
		'id' => 'exclude_pages',
		'std' => '1',
		'type' => 'checkbox');

	// Footer Buttons
	$options[] = array(
		'name' => __('Footer Buttons', 'lbprojects'),
		'type' => 'heading');
		
	$options[] = array(
		'name' => __('Display RSS Button', 'lbprojects'),
		'desc' => __('Display RSS Buttons in the site\'s footer.', 'lbprojects'),
		'id' => 'rss_button',
		'std' => '1',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Display Social Buttons', 'lbprojects'),
		'desc' => __('Enable Social Buttons in the site\'s footer.', 'lbprojects'),
		'id' => 'social_buttons',
		'std' => '1',
		'class' => 'parent',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('YouTube', 'lbprojects'),
		'desc' => __('Enter your YouTube account name.', 'lbprojects'),
		'id' => 'button_youtube',
		'std' => 'LBHomeprojects',
		'class' => 'child-social_buttons',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Facebook', 'lbprojects'),
		'desc' => __('Enter the URL to your Facebook profile.', 'lbprojects'),
		'id' => 'button_facebook',
		'std' => '',
		'class' => 'child-social_buttons',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Twitter', 'lbprojects'),
		'desc' => __('Enter the URL to your Twitter profile.', 'lbprojects'),
		'id' => 'button_twitter',
		'std' => 'https://twitter.com/LukasBommes',
		'class' => 'child-social_buttons',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Googleplus', 'lbprojects'),
		'desc' => __('Enter the URL to your Googleplus profile.', 'lbprojects'),
		'id' => 'button_googleplus',
		'std' => '',
		'class' => 'child-social_buttons',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Linkedin', 'lbprojects'),
		'desc' => __('Enter the URL to your Linkedin profile.', 'lbprojects'),
		'id' => 'button_linkedin',
		'std' => '',
		'class' => 'child-social_buttons',
		'type' => 'text');

	// Gallery Options
	$options[] = array(
		'name' => __('Gallery Options', 'lbprojects'),
		'type' => 'heading');
		
	$options[] = array(
		'name' => __('Gallery Lightbox', 'lbprojects'),
		'desc' => __('Enable lightbox effect for image gallerys.', 'lbprojects'),
		'id' => 'lightbox_enable',
		'std' => '1',
		'class' => 'parent',
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => __('Navigation Buttons', 'lbprojects'),
		'desc' => __('Display buttons with navigation elements on top of the lightbox.', 'lbprojects'),
		'id' => 'lightbox_buttons',
		'std' => '0',
		'class' => 'child-lightbox_enable',
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => __('Browse Images with Mouse Wheel', 'lbprojects'),
		'desc' => __('Enable support for mouse wheel for image scrolling.', 'lbprojects'),
		'id' => 'lightbox_mousewheel',
		'std' => '0',
		'class' => 'child-lightbox_enable',
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => __('Autoplay', 'lbprojects'),
		'desc' => __('Enable lightbox autoplay.', 'lbprojects'),
		'id' => 'lightbox_autoplay',
		'std' => '0',
		'class' => 'child-lightbox_enable',		
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Autoplay Duration', 'lbprojects'),
		'desc' => __('Enter the display duration for each image in millisecods.', 'lbprojects'),
		'id' => 'lightbox_playspeed',
		'std' => '3000',
		'class' => 'child-lightbox_enable mini',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Preview Images', 'lbprojects'),
		'desc' => __('Display thumbnail images below the lightbox.', 'lbprojects'),
		'id' => 'lightbox_thumbs',
		'std' => '0',
		'class' => 'child-lightbox_enable',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Browse Animation', 'lbprojects'),
		'desc' => __('Select the animation method for image browsing.', 'lbprojects'),
		'id' => 'lightbox_browseeffect',
		'std' => 'elastic',
		'type' => 'select',
		'class' => 'child-lightbox_enable mini',
		'options' => array( 'fade' => __('fade', 'lbprojects'), 'elastic' => __('elastic', 'lbprojects'), 'none' => __('none', 'lbprojects') ) );

	$options[] = array(
		'name' => __('Opening Animation', 'lbprojects'),
		'desc' => __('Select the animation method for the lightbox opening and closing.', 'lbprojects'),
		'id' => 'lightbox_openeffect',
		'std' => 'fade',
		'type' => 'select',
		'class' => 'child-lightbox_enable mini',
		'options' => array( 'fade' => __('fade', 'lbprojects'), 'elastic' => __('elastic', 'lbprojects'), 'none' => __('none', 'lbprojects') ) );

	$options[] = array(
		'name' => __('Title Appearance', 'lbprojects'),
		'desc' => __('Select the appearance of the image title.', 'lbprojects'),
		'id' => 'lightbox_titletype',
		'std' => 'inside',
		'type' => 'select',
		'class' => 'child-lightbox_enable mini',
		'options' => array( 'float' => __('outside box', 'lbprojects'), 'inside' => __('inside', 'lbprojects'), 'outside' => __('outside', 'lbprojects'), 'over' => __('overlay', 'lbprojects') ) );
		
	$options[] = array(
		'name' => __('Gallery Pagination', 'lbprojects'),
		'desc' => __('Enable pagination for Wordpress default gallery.', 'lbprojects'),
		'id' => 'paginated_gallery',
		'std' => '1',
		'class' => 'parent',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Number of gallery items', 'lbprojects'),
		'desc' => __('Enter the number of gallery items being displayed on each gallery page.', 'lbprojects'),
		'id' => 'paginated_gallery_count',
		'std' => '15',
		'class' => 'child-paginated_gallery mini',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Gallery Caption', 'lbprojects'),
		'desc' => __('Display image description below each gallery item.', 'lbprojects'),
		'id' => 'gallery_caption',
		'std' => '0',
		'type' => 'checkbox');
	
	// Slider Options
	$options[] = array(
		'name' => __('Slider Options', 'lbprojects'),
		'type' => 'heading');
		
	$options[] = array(
		'name' => __('Featured Post Slider', 'lbprojects'),
		'desc' => __('This Option allows you to add posts to a slider on your static frontpage. Simply go to the WordPress post editor and check the Option in the custom meta box "Featured Post" to append the article to the slider.', 'lbprojects'),
		'type' => 'info');

	$options[] = array(
		'name' => __('Enable Featured Post Slider', 'lbprojects'),
		'desc' => __('Enable featured post slider on the front page.', 'lbprojects'),
		'id' => 'featured_posts',
		'std' => '0',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Front Page Slideshow', 'lbprojects'),
		'desc' => __('The front page slider will contain large images and text. That allows you to focus on special content and get high clickrates on this specific content. If you do not want to use the slider uncheck the option below.', 'lbprojects'),
		'type' => 'info');

	$options[] = array(
		'name' => __('Display Slideshow', 'lbprojects'),
		'desc' => __('Enable image slideshow on the front page.', 'lbprojects'),
		'id' => 'show_slideshow',
		'std' => '1',
		'class' => 'parent',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Slider Image', 'lbprojects') . ' 1',
		'id' => 'slider_1',
		'std' => array( 'image' => '', 'title' => '', 'link' => '', 'text' => '' ),
		'class' => 'child-show_slideshow',
		'type' => 'slider');
		
	$options[] = array(
		'name' => __('Slider Image', 'lbprojects') . ' 2',
		'id' => 'slider_2',
		'std' => array( 'image' => '', 'title' => '', 'link' => '', 'text' => '' ),
		'class' => 'child-show_slideshow',
		'type' => 'slider');
		
	$options[] = array(
		'name' => __('Slider Image', 'lbprojects') . ' 3',
		'id' => 'slider_3',
		'std' => array( 'image' => '', 'title' => '', 'link' => '', 'text' => '' ),
		'class' => 'child-show_slideshow',
		'type' => 'slider');
		
	$options[] = array(
		'name' => __('Slider Image', 'lbprojects') . ' 4',
		'id' => 'slider_4',
		'std' => array( 'image' => '', 'title' => '', 'link' => '', 'text' => '' ),
		'class' => 'child-show_slideshow',
		'type' => 'slider');
		
	$options[] = array(
		'name' => __('Slider Image', 'lbprojects') . ' 5',
		'id' => 'slider_5',
		'std' => array( 'image' => '', 'title' => '', 'link' => '', 'text' => '' ),
		'class' => 'child-show_slideshow',
		'type' => 'slider');
		
	$options[] = array(
		'name' => __('Slider Image', 'lbprojects') . ' 6',
		'id' => 'slider_6',
		'std' => array( 'image' => '', 'title' => '', 'link' => '', 'text' => '' ),
		'class' => 'child-show_slideshow',
		'type' => 'slider');
		
	$options[] = array(
		'name' => __('Slider Image', 'lbprojects') . ' 7',
		'id' => 'slider_7',
		'std' => array( 'image' => '', 'title' => '', 'link' => '', 'text' => '' ),
		'class' => 'child-show_slideshow',
		'type' => 'slider');
		
	$options[] = array(
		'name' => __('Slider Image', 'lbprojects') . ' 8',
		'id' => 'slider_8',
		'std' => array( 'image' => '', 'title' => '', 'link' => '', 'text' => '' ),
		'class' => 'child-show_slideshow',
		'type' => 'slider');
		
	$options[] = array(
		'name' => __('Slider Image', 'lbprojects') . ' 9',
		'id' => 'slider_9',
		'std' => array( 'image' => '', 'title' => '', 'link' => '', 'text' => '' ),
		'class' => 'child-show_slideshow',
		'type' => 'slider');
		
	$options[] = array(
		'name' => __('Slider Image', 'lbprojects') . ' 10',
		'id' => 'slider_10',
		'std' => array( 'image' => '', 'title' => '', 'link' => '', 'text' => '' ),
		'class' => 'child-show_slideshow',
		'type' => 'slider');

	return $options;
}

// Fade and hide options depending on other options
function optionsframework_custom_scripts() {
	echo '<script type="text/javascript">
			/* <![CDATA[ */
			jQuery(document).ready(function($){				
				$(".parent").each(function(){				
					var parent_id = $(this).find(".of-input").attr("id");					
					if( !$("#" + parent_id).attr("checked") ){
						$(".child-" + parent_id).hide();
					}					
					$("#" + parent_id).click(function(){
						$(".child-" + parent_id).fadeToggle();
					});					
				});				
			});
			/* ]]> */
		</script>';	
}
add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');
?>
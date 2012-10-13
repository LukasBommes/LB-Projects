<?php

/*
*	functions.php
*	Custom Functions
*/

// Print Google Analytics tracking code and script in the header
function LB_localize_google_tracking_var(){
	return array( 'ga_user_code' => of_get_option('ga_code') );
}

function LB_enqueue_google_tracking_code() {
	if( of_get_option('ga_code') ) {
		wp_enqueue_script('ga-tracking', get_template_directory_uri() .'/js/ga-tracking.js');
		wp_localize_script('ga-tracking', 'ga_tracking_var', LB_localize_google_tracking_var());
	}
}
add_action( 'wp_enqueue_scripts', 'LB_enqueue_google_tracking_code' );


// Hook initialization scripts for slideshow and navigation
function LB_init_config_scripts() {
	echo '<script type="text/javascript">
			/* <![CDATA[ */
			supersubs_init();
			superfish_init();
			slider_init();
			/* ]]> */
		</script>';
}
add_action('wp_head', 'LB_init_config_scripts');


// Customize backend
function LB_admin_style() {
	if( of_get_option('admin_style') ) {
		wp_enqueue_style('admin-style', get_template_directory_uri() . '/css/admin.css');
	}
}
add_action('admin_head', 'LB_admin_style');

function LB_admin_bar() {
	wp_enqueue_style('admin-bar-style', get_template_directory_uri() . '/css/admin-bar.css');
}
add_action('admin_head', 'LB_admin_bar');
add_action('wp_head', 'LB_admin_bar');

function LB_admin_footer() {
	echo __('Theme designed and developed by', 'lbprojects') . ' <a href="http://projects.lb-home.de" target="_blank">' . __('LB-Projects', 'lbprojects') . '</a> | ' . __('Powered by', 'lbprojects') . ' <a href="http://wordpress.org" target="_blank">' . __('WordPress', 'lbprojects') . '</a>.';
}
add_filter('admin_footer_text', 'LB_admin_footer');


// Function for enabling the maintenance mode
function LB_maintenance_mode() {
	if( of_get_option('maintenance_mode') ) {
		if ( !current_user_can( 'edit_themes' ) || !is_user_logged_in() ) {
			wp_die( __('Maintenance, please come back soon.', 'lbprojects') );
		}
	}
}
add_action('get_header', 'LB_maintenance_mode');


// Optionally open external links in new tab or window
function LB_external_links() {
	if( of_get_option('external_links') ) {
	
		of_get_option('external_links_marker') ? $external_link_marker = '<sup class="external-link"><i class="icon-external-link"></i></sup>' : $external_link_marker = '';
		
		echo '<script type="text/javascript">
				/* <![CDATA[ */
				$(document).ready(function(){
					$("a[href^=\'http:\']").not("[href*=\'' . site_url() . '\']").attr(\'target\',\'_blank\');
					$(".entry a[href^=\'http:\']").not("[href*=\'' . site_url() . '\']").append(\'' . $external_link_marker . '\');
				});
				/* ]]> */
			</script>';
	}
}
add_action('wp_head', 'LB_external_links');


// Display post thumbnails in the feed
function LB_rss_post_thumbnail($content) {
    global $post;
    if( has_post_thumbnail($post->ID) ) {
        $content = '<p>' . get_the_post_thumbnail( $post->ID, 'medium' ) . '</p>' . get_the_content();
    }
    return $content;
}
add_filter('the_excerpt_rss', 'LB_rss_post_thumbnail');
add_filter('the_content_feed', 'LB_rss_post_thumbnail');


// Add column for post thumbnail to the post overview
function LB_add_post_thumbnail_column($cols){
	$cols['LB_post_thumb'] = __('Featured', 'lbprojects');
	return $cols;
}
add_filter('manage_posts_columns', 'LB_add_post_thumbnail_column', 5);
add_filter('manage_pages_columns', 'LB_add_post_thumbnail_column', 5);

function LB_post_thumbnail_column($col, $id){
add_image_size( 'featured-thumbnail', 100, 75, true );
	if( $col == 'LB_post_thumb' ) {
		the_post_thumbnail( 'featured-thumbnail' );
	}
}
add_action('manage_posts_custom_column', 'LB_post_thumbnail_column', 5, 2);
add_action('manage_pages_custom_column', 'LB_post_thumbnail_column', 5, 2);


// Add column for post post like count
function LB_add_post_like_column($cols){
	$cols['LB_post_like'] = __('Likes', 'lbprojects');
	return $cols;
}
add_filter('manage_posts_columns', 'LB_add_post_like_column', 5);

function LB_post_like_column($col, $id){
	if( $col == 'LB_post_like' ) {
		echo getPostLikeLink(get_the_ID());
	}
}
add_action('manage_posts_custom_column', 'LB_post_like_column', 5, 2);


// Add favicon to frontend and backend
function LB_favicon() {
	if( of_get_option('favicon') ) {
		$favicon = of_get_option('favicon');
	} else {
		$favicon = get_template_directory_uri() . '/images/favicon.ico';
	}	
	echo '<link href="' . $favicon . '" rel="shortcut icon" />';
}
add_action( 'admin_head', 'LB_favicon' );
add_action( 'login_head', 'LB_favicon' );
add_action( 'wp_head', 'LB_favicon' );


// Custmize login page
function LB_custom_login_style() {
	echo '<link rel="stylesheet" type="text/css" href="' . get_template_directory_uri() . '/css/custom-login.css" />';
}
add_action( 'login_enqueue_scripts', 'LB_custom_login_style' );

function LB_login_logo_url() {
    return home_url();
}
add_filter('login_headerurl', 'LB_login_logo_url');

function LB_login_logo_title() {
    return 'Powered by LB-Projects';
}
add_filter('login_headertitle', 'LB_login_logo_title');


// Create login form in the site header
function LB_loginform() {
	$form = '<form name="loginform" id="loginform" action="' . esc_url( site_url( 'wp-login.php', 'login_post' ) ) . '" method="post">
				<p class="login-username">
					<label for="user-login"><i class="icon-user icon-large"></i></label>
					<input type="text" name="log" id="user-login" class="input-text" value="' . __('Username', 'lbprojects') . '" size="20" tabindex="10" />
				</p>		
				<p class="login-password">
					<label for="user-pass"><i class="icon-lock icon-large"></i></label>
					<input type="password" name="pwd" id="user-pass" class="input-text" value="' . __('Password', 'lbprojects') . '" size="20" tabindex="20" />
				</p>
				<p class="login-remember"><label><input name="rememberme" type="checkbox" id="rememberme" value="forever" tabindex="90" />' . __('Remember me?', 'lbprojects') . '</label></p>
				<p class="login-submit">
					<input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="' . __('Sign in', 'lbprojects') . '" tabindex="100" />
					<input type="hidden" name="redirect-to" value="' . site_url( $_SERVER['REQUEST_URI'] ) . '" />
				</p>
			</form>';
	echo $form;
}


// Filter comment form inputs
function LB_comment_fields() {
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	
	if( esc_attr( $commenter['comment_author'] ) ) { $author_val = esc_attr( $commenter['comment_author'] ); }
	else { $author_val = __('Name', 'lbprojects'); }
		
	if( esc_attr(  $commenter['comment_author_email'] ) ) {	$email_val = esc_attr(  $commenter['comment_author_email'] ); } 
	else { $email_val = __('Email', 'lbprojects'); }
		
	if( esc_attr( $commenter['comment_author_url'] ) ) { $url_val = esc_attr( $commenter['comment_author_url'] ); } 
	else { $url_val = __('Website', 'lbprojects'); }

	$fields =  array(
		'author' => '<p class="comment-form-author">' . '<label for="author"><i class="icon-user icon-large"></i></label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
					'<input id="author" name="author" type="text" class="input-text" value="' . $author_val . '" size="30"' . $aria_req . ' /></p>',
		'email'  => '<p class="comment-form-email"><label for="email"><i class="icon-envelope-alt icon-large"></i></label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
					'<input id="email" name="email" type="text" class="input-text" value="' . $email_val . '" size="30"' . $aria_req . ' /></p>',
		'url'    => '<p class="comment-form-url"><label for="url"><i class="icon-home icon-large"></i></label>' .
					'<input id="url" name="url" type="text" class="input-text" value="' . $url_val . '" size="30" /></p>',
	);
	
	return $fields;
}
add_filter('comment_form_default_fields', 'LB_comment_fields');


// Filter for title function
function LB_filter_title( $title, $sep, $sep_location ) {	
	$ssep = ' ' . $sep . ' ';
	if ( is_front_page() || is_home() || is_paged() ) {
		$modified_title = 'Home' . $ssep . get_bloginfo( 'name' );
	} else if ( is_author() ) {
		global $wp_query;
		$curauth = $wp_query->get_queried_object();
		$modified_title = $curauth->display_name . $ssep . get_bloginfo( 'name' );
	} else { 
		$modified_title = $title;
	}
	return $modified_title;
}
add_filter('wp_title', 'LB_filter_title', 10, 3);


// Modifiy the excerpt function
function custom_excerpt_length( $length ) {
	return 18;
}
add_filter('excerpt_length', 'custom_excerpt_length', 999);

function new_excerpt_more( $more ) {
	global $post;
	return '&hellip; ' . '<a href="' . get_permalink($post->ID) . '" class="featured-more-link">' . __('read more', 'lbprojects') . '&rarr;' . '</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');


// Exclude pages from search
function LB_search_exclude_pages( $query ) {
	if( of_get_option('exclude_pages') ) {
		if( $query->is_search ) {
			$query->set('post_type', 'post');
		}
		return $query;
	}
}
add_filter('pre_get_posts','LB_search_exclude_pages');


// Customize searchform
function LB_search_form( $form ) {
    $form = '<form role="search" method="get" class="searchform" action="' . home_url( '/' ) . '">
				<input type="text" class="input-text s" name="s" value="' . __('Search', 'lbprojects') . '" />
				<button class="searchsubmit"><i class="icon-search"></i></button>
			</form>';
    return $form;
}
add_filter('get_search_form', 'LB_search_form');


// Modify wp_page_menu as fallback for Superfish navigation
function LB_custom_page_menu($ulclass) {
	return preg_replace('/<ul>/', '', $ulclass, 1);	
}
add_filter('wp_page_menu', 'LB_custom_page_menu');


// Initialize lightbox plugin
function LB_init_lightbox() {
	if( of_get_option('lightbox_enable') ) {
		?><script type="text/javascript">
			/* <![CDATA[ */
			$(document).ready(function() {
				$("a[href$='.jpg'],a[href$='.png'],a[href$='.gif']").attr('rel', 'gallery').fancybox({				
					padding: 9,
					maxWidth: 1200,
					maxHeight: 700,
					<?php echo is_admin_bar_showing() || of_get_option('lightbox_buttons') ? 'margin: [50,20,20,20],' : 'margin: [20,20,20,20],'; ?>
					mouseWheel: <?php echo of_get_option('lightbox_mousewheel') ? 'true' : 'false'; ?>,
					autoPlay: <?php echo of_get_option('lightbox_autoplay') ? 'true' : 'false'; ?>,
					playSpeed: '<?php echo of_get_option('lightbox_playspeed'); ?>',
					closeBtn: <?php echo of_get_option('lightbox_buttons') ? 'false' : 'true'; ?>,
					arrows: <?php echo of_get_option('lightbox_buttons') ? 'false' : 'true'; ?>,
					prevEffect: '<?php echo of_get_option('lightbox_browseeffect'); ?>',
					nextEffect: '<?php echo of_get_option('lightbox_browseeffect'); ?>',
					openEffect: '<?php echo of_get_option('lightbox_openeffect'); ?>',
					closeEffect: '<?php echo of_get_option('lightbox_openeffect'); ?>',
					helpers: {
						title: { type: '<?php echo of_get_option('lightbox_titletype'); ?>' },
						<?php echo of_get_option('lightbox_thumbs') ? 'thumbs: { width: 80, height: 80 },' : ''; ?>
						<?php echo of_get_option('lightbox_buttons') ? 'buttons: {}' : ''; ?>
					},
					beforeLoad: function(){				
						var gallery_caption = $(this.element).closest('.gallery-item').find('.wp-caption-text').html();
						var image_caption = $(this.element).closest('.wp-caption').find('.wp-caption-text').html();				
						if(gallery_caption){
							this.title = gallery_caption;
						} else {
							this.title = image_caption;
						}
					},
				});
			});
			/* ]]> */
		</script><?	
	}
}
add_action('wp_head', 'LB_init_lightbox');


// Options for custom styles and functions
function LB_style_options() {
	echo '<style type="text/css">';
	
		if( !of_get_option('gallery_caption') ) {
			echo '.entry .gallery-caption { display: none; }';
		}
	
		$typography = of_get_option('typography');
		if ($typography) {
			echo 'body { font-family: ' . $typography['face'] . '; font-size:' . $typography['size'] . '; font-style: ' . $typography['style'] . '; color:' . $typography['color'] . ';}';
		}
	
		$background = of_get_option('background');			
		if( $background['color'] || $background['image'] ) {
			echo 'body { background:' . $background['color'] . ' ' . 'url("' . $background['image'] . '") ' . $background['repeat'] . ' ' . $background['position'] . ' ' . $background['attachment'] . ' !important;}';
		}
		
		if( of_get_option('custom_css') ) {
			echo of_get_option('custom_css');
		}
		
		if( of_get_option('header_scroll') == 'two' ) {
			echo '#header { position: fixed !important; }';
			wp_enqueue_script('fixed-header-scroll', get_template_directory_uri() . '/js/fixed-header-scroll.js');
		}
		
		if( of_get_option('sidebar_position') == 'left_sidebar' ) {
			echo '#sidebar { float: left; margin-left: 0; }
				#content { float: right; }';
		}
		
		echo '#header { background-color:' . of_get_option('header_color') . ';}'
		.'#footer { background-color:' . of_get_option('footer_color') . ';}'
		.'::selection { background-color:' . of_get_option('link_color') . ';}'
		.'::-moz-selection { background-color:' . of_get_option('link_color') . ';}'
		.'::-webkit-selection { background-color:' . of_get_option('link_color') . ';}'
		.'.article .title h2 a:hover { color:' . of_get_option('link_color') . ';}'
		.'.article .article-comments:hover a { background-color:' . of_get_option('link_color') . ';}'
		.'.article .article-comments:hover span { border-top: 7px solid' . of_get_option('link_color') . ' !important;}'
		.'#article-wrapper #related-posts ul li span a:hover { background-color:' . of_get_option('link_color') . ';}'
		.'#article-wrapper #rand-posts ul li span a:hover { background-color:' . of_get_option('link_color') . ';}'
		.'#toggle-comment:hover { background-color:' . of_get_option('link_color') . ';}'				
		.'a, a:active, a:visited { color:' . of_get_option('link_color') . ';}'
		.'#tagcloud a:hover { color:' . of_get_option('link_color') . ';}'
		.'a.attachment-linkback:hover { color:' . of_get_option('link_color') . ';}'
		.'.sticky { border-left-color:' . of_get_option('link_color') . ';}';
	
	echo '</style>';
}
add_action('wp_head', 'LB_style_options');

?>
<?php 
/*
*	header.php
*
*	LB-Projects Theme
*	Author: Lukas Bommes
*	Copyright (C) Lukas Bommes
*/ 
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	
	<!-- Site title -->
	<title><?php wp_title(); ?></title>
	
	<!-- Links -->
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php wp_head(); ?>
	
	<!-- Initialize scripts -->
	<script type="text/javascript">
		/* <![CDATA[ */
		supersubs_init();
		superfish_init();
		slider_init();
		/* ]]> */
	</script>

</head>

<body <?php body_class(); ?>>
	
	<!-- Back to Top -->
	<?php if( of_get_option('scroll_button') ) : ?>
		<div id="back-top">
			<a href="#top" title="<?php _e('Scroll to top', 'lbprojects'); ?>"><i class="icon-chevron-up"></i></a>
		</div>
	<?php endif; ?>

	<div id="header">
	
		<!-- Logo -->
		<a href="<?php echo home_url(); ?>">

			<?php if( of_get_option('logo') ) : ?>
				<img id="logo" src="<?php echo of_get_option('logo'); ?>" />
			<?php else : ?>			
				<img id="logo" src="<?php echo get_template_directory_uri(); ?>/images/logo.png" />
			<?php endif; ?> 
		  
		</a>

		<div id="header-wrapper">
			
			<!-- Main navigation -->
			<div class="nav-wrapper">
				<?php wp_nav_menu( array( 'theme_location'  => 'header', 'menu_class' => 'sf-menu', 'fallback_cb' => 'wp_page_menu', 'depth' => 3 ) ); ?>
			</div>
			
			<!-- Header forms -->
			<div id="header-boxes">
				
				<?php $header_forms = of_get_option('header_form'); ?>
				
				<?php if( $header_forms['two'] ) : ?>
					<div id="search-open"><?php _e('Search', 'lbprojects'); ?></div>
					<?php get_search_form(); ?>
				<?php endif; ?>
				
				<?php if( $header_forms['one'] ) : ?>
					<?php if( is_user_logged_in() ) : ?>
						<a href="<?php echo wp_logout_url(get_permalink()); ?>" id="logout"><?php _e('Sign out', 'lbprojects'); ?></a>
					<?php else : ?>
						<a id="login-open"><?php _e('Sign in', 'lbprojects'); ?></a>
						<?php LB_loginform(); ?>
					<?php endif; ?>
				<?php endif; ?>
			
			</div>

		</div>
		
	</div>

	<div id="wrapper">

		<div id="main">
			
			<!-- Header image -->
			<?php if( of_get_option('header_image') ) : ?>
				<img id="header-image" src="<?php echo of_get_option('header_image'); ?>" />
			<?php endif; ?>
			
			<!-- Content -->
			<?php if( is_page_template('fullwidth.php') ) : ?>
				<div id="content-fullwidth">
			<?php else : ?>
				<div id="content">
			<?php endif; ?>

				<!-- Breadcrumb navigation -->
				<?php if( of_get_option('breadcrumb') ) :
					nav_breadcrumb();
				endif; ?>
				
				<noscript>
					<div id="noscript-warning">
						<p><?php _e('Javascript is disabled on your browser. Some features of this website may not work properly.', 'lbprojects'); ?></p>
					</div>
				</noscript>
<?php 
/*
*	404.php
*
*	LB-Projects Theme
*	Author: Lukas Bommes
*	Copyright (C) Lukas Bommes
*/ 
?>

<?php get_header(); ?>

	<?php LB_announce_widget(); ?>
	
	<div class="page-not-found" id="article-wrapper">

		<div class="article">
			
			<div class="title">
				<h2><?php _e('The requested site could not be found!', 'lbprojects'); ?></h2>
			</div>
				
			<div class="clear"></div>	
			
			<div class="entry">
			
				<img id="img404" src="<?php echo get_template_directory_uri(); ?>/images/404.png" /> 
		
				<p>
					<?php _e('Browse the website via site search or use the navigation. Please contact the administrator if the error remains.', 'lbprojects'); ?>
				</p>
				
				<p id="admin404-text">
				
					<?php $user = get_user_by('email', get_bloginfo('admin_email'));
					
					if( isset( $user->display_name ) ) {
					
						echo '<span>' . $user->display_name . '</span>';
						
					} ?>
					
					<span><a href="mailto:<?php bloginfo('admin_email'); ?>"><?php bloginfo('admin_email'); ?></a></span>
				
				</p>

			</div>
			
		</div>
	
	</div><!-- article-wrapper -->

	</div><!-- content --> 

	<?php get_sidebar(); ?>              

	</div><!-- main -->

	</div><!-- wrapper -->

<?php get_footer(); ?>
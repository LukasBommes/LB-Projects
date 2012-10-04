<?php 
/*
*	footer.php
*
*	LB-Projects Theme
*	Author: Lukas Bommes
*	Copyright (C) Lukas Bommes
*/ 
?>

<div id="footer">

	<div id="footer-wrapper">

		<!-- Social Media Buttons -->
	
		<div id="footer-icons">

	    	<?php if( of_get_option('rss_button') ) : ?>

			<a href="<?php bloginfo('rss2_url'); ?>" target="blank" title="<?php _e('subscribe Newsfeed', 'lbprojects'); ?>" class="footer-rss"><?php _e('RSS', 'lbprojects'); ?></a>
		
	    	<?php endif; ?>		

	    	<?php if( of_get_option('social_buttons') ) : ?>

			<?php if( of_get_option('button_facebook') ) : ?>	
				<a href="<?php echo of_get_option('button_facebook'); ?>" target="blank" title="<?php _e('my Facebook profile', 'lbprojects'); ?>" class="footer-facebook"><?php _e('Facebook', 'lbprojects'); ?></a>
			<?php endif; ?>

			<?php if( of_get_option('button_twitter') ) : ?>	
				<a href="<?php echo of_get_option('button_twitter'); ?>" target="blank" title="<?php _e('follow me on twitter', 'lbprojects'); ?>" class="footer-twitter"><?php _e('Twitter', 'lbprojects'); ?></a>
			<?php endif; ?>

			<?php if( of_get_option('button_googleplus') ) : ?>	
				<a href="<?php echo of_get_option('button_googleplus'); ?>" target="blank" title="<?php _e('my Googleplus profile', 'lbprojects'); ?>" class="footer-googleplus"><?php _e('Google+', 'lbprojects'); ?></a>
			<?php endif; ?>

			<?php if( of_get_option('button_linkedin') ) : ?>	
				<a href="<?php echo of_get_option('button_linkedin'); ?>" target="blank" title="<?php _e('my Linkedin profile', 'lbprojects'); ?>" class="footer-linkedin"><?php _e('Linkedin', 'lbprojects'); ?></a>
			<?php endif; ?>
			
			<?php if( of_get_option('button_youtube') ) : ?>	
				<a href="http://www.youtube.com/user/<?php echo of_get_option('button_youtube'); ?>" target="blank" title="<?php echo of_get_option('button_youtube'); ?> <?php _e('on YouTube', 'lbprojects'); ?>" class="footer-youtube"><?php _e('YouTube', 'lbprojects'); ?></a>
			<?php endif; ?>

	   	<?php endif; ?>

		</div>

		<!-- Footer Widgets -->

		<?php if ( is_active_sidebar('footer-widget1') || is_active_sidebar('footer-widget2') || is_active_sidebar('footer-widget3') || is_active_sidebar('footer-widget4') ) : ?>	

			<div id="footer-widgets">
			
				<ul class="footer-column column-1">
					<?php dynamic_sidebar('footer-widget1'); ?>
				</ul>
				
				<ul class="footer-column column-2">
					<?php dynamic_sidebar('footer-widget2'); ?>
				</ul>
				
				<ul class="footer-column column-3">
					<?php dynamic_sidebar('footer-widget3'); ?>
				</ul>
				
				<ul class="footer-column column-4">
					<?php dynamic_sidebar('footer-widget4'); ?>
				</ul>
				
			</div>
			
			<div class="clear"></div>
			
		<?php endif; ?>
		
		<div id="tagline"><?php bloginfo('description'); ?></div>

	</div><!-- footer-wrapper -->
	
</div><!-- footer -->

<div id="legacy-footer">

	<div id="legacy-footer-wrapper">

		<?php if( of_get_option('footer_text') ) : ?>
			<span id="copy"><?php echo of_get_option('footer_text'); ?></span>
		<?php endif; ?>

		<span id="credits"><?php _e('Powered by', 'lbprojects'); ?> <a href="http://wordpress.org/" target="blank"><?php _e('WordPress', 'lbprojects'); ?></a> | <?php _e('Theme developed by', 'lbprojects'); ?> <a href="http://projects.lb-home.de/"><?php _e('LB-Projects', 'lbprojects'); ?></a></span>

	</div>

	<div class="clear"></div>

</div><!-- legacy-footer -->

<?php wp_footer(); ?>

</body>

</html>
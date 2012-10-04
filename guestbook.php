<?php 
/*
Template Name: Guestbook
*/
?>

<?php 
/*
*	guestbook.php
*
*	LB-Projects Theme
*	Author: Lukas Bommes
*	Copyright (C) Lukas Bommes
*/ 
?>

<?php get_header(); ?>

	<?php LB_announce_widget(); ?>

	<?php comments_template( '/gb_comments.php' ); ?> 

	</div><!-- content --> 

	<?php get_sidebar(); ?>              

	</div><!-- main -->

	</div><!-- wrapper -->

<?php get_footer(); ?>
<?php 
/*
*	comments.php
*
*	LB-Projects Theme
*	Author: Lukas Bommes
*	Copyright (C) Lukas Bommes
*/ 
?>

<?php
// Security functions for Spam-Bots and password protection
	if(!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die( __('Please do not load this page directly. Thanks!', 'lbprojects') );

	if( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'lbprojects'); ?></p>
	<?php
		return;
	}
?>

<?php if ( comments_open() ) : ?>

	<div id="kommentar-formular">

		<?php comment_form( array(
			'cancel_reply_link' => '<i class="icon-trash"></i>' . __('Cancel Reply', 'lbprojects'),
			'comment_notes_after' => '',
			'comment_notes_before' => '<p class="comment-notes">' . __('Your email address will not be published. Required fields are marked.', 'lbprojects') . '</p>',
			'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" tabindex="4" aria-required="true"></textarea></p>' ) ); ?>

	</div>

	<div id="comment-wrapper">
	
		<?php if(get_comments_number()) : ?>
	
			<div id="comment-header">
			
				<a class="active" id="toggle-comment" href="#"><?php _e('Toggle comments', 'lbprojects'); ?></a>

				<?php if (get_comments_number() == '1') : ?>
					<h3 id="comment-count"><?php _e('1 comment to', 'lbprojects'); ?> "<?php the_title(); ?>"</h3> 
				<?php endif; ?>

				<?php if (get_comments_number() > '1') : ?>
					<h3 id="comment-count"><?php echo get_comments_number(); ?> <?php _e('comments to', 'lbprojects'); ?> "<?php the_title(); ?>"</h3>
				<?php endif; ?>
				
			</div>
		
		<?php else : ?>
			
			<p class="null-comments"><?php _e('There are no comments to this topic.', 'lbprojects'); ?></p>
			
		<?php endif; ?>
		
		<div id="commentlist">
		
			<?php wp_list_comments( 'avatar_size=70' ); ?>

			<div class="pagination">
				<?php paginate_comments_links( array( 'prev_text' => '<i class="icon-chevron-left"></i>', 'next_text' => '<i class="icon-chevron-right"></i>', 'end_size' => 2, 'mid_size' => 1 ) ); ?>
			</div>
			
		</div>

	</div><!-- comment-wrapper -->

<?php else : ?>

	<div id="nocomments">
		<?php _e('Comments are off.', 'lbprojects'); ?>
	</div>

<?php endif; ?>
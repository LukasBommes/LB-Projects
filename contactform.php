<?php 
/*
Template Name: Contactform
*/
?>

<?php 
/*
*	contactform.php
*
*	LB-Projects Theme
*	Author: Lukas Bommes
*	Copyright (C) Lukas Bommes
*/ 
?>

<?php // Form functions

global $name_s, $email_s, $subject_s, $message_s;

if( isset( $_POST['submitted'] ) ) {

	// Name
	if(stripslashes(trim($_POST['contactName'])) == '') {
		$hasError = true;
	} 
	else {
		$name = stripslashes(trim($_POST['contactName']));
	}
	
	// Email
	if(stripslashes(trim($_POST['contactEmail'])) == '')  {
		$hasError = true;
	}
	// Check email
	else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", stripslashes(trim($_POST['contactEmail'])))) {
		$hasError = true;
	} 
	else {
		$eMail = stripslashes(trim($_POST['contactEmail']));
	}
	
	// Subject
	if(stripslashes(trim($_POST['contactSubject'])) == '') {
		$hasError = true;
	} 
	else {
		$subject = stripslashes(trim($_POST['contactSubject']));
	}
	
	// Message
	if(stripslashes(trim($_POST['contactMessage'])) == '') {
		$hasError = true;
	} 
	else {
		$message = stripslashes(trim($_POST['contactMessage']));
	}
	
	// Send email
	if(!isset($hasError)) {
		$emailTo = get_option('admin_email');
		$body = "Nachricht vom Blog gesendet:\n\nName: $name \neMail: $eMail \n\n".
				"Betreff: $subject \nNachricht: $message";
		$headers = 'From: '.$name.' < '.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $eMail;
		mail($emailTo, $subject, $body, $headers);
		$emailSent = true;
	} 
	
	// Do not reset fields on send error
	if(isset($hasError)) {
		$name_s = stripslashes(trim($_POST['contactName']));
		$email_s = stripslashes(trim($_POST['contactEmail']));
		$subject_s = stripslashes(trim($_POST['contactSubject']));
		$message_s = stripslashes(trim($_POST['contactMessage']));
	}
}
?>

<?php get_header(); ?>
	
	<?php LB_announce_widget(); ?>
	
	<div id="article-wrapper">
                
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
			<div class="article">
			
				<h2 class="title"><?php the_title(); ?></h2>
					
				<div class="entry">
				
				<?php the_content( __('read more', 'lbprojects') ); ?>
				
					<form action="<?php the_permalink(); ?>" id="contactForm" method="post">
					
						<p class="contact-form-name">
							<input type="text" name="contactName" id="contactName" class="input-text" value="<?php if( $name_s ) { echo esc_html( $name_s ); } else { echo __('Name', 'lbprojects'); } ?>" />
							<label for="contactName"><i class="icon-user icon-large"></i></label>
						</p>
						
						<p class="contact-form-email">
							<input type="text" name="contactEmail" id="contactEmail" class="input-text" value="<?php if( $email_s ) { echo esc_html( $email_s ); } else { echo __('Email', 'lbprojects'); } ?>" />
							<label for="contactEmail"><i class="icon-envelope-alt icon-large"></i></label>
						</p>
						
						<p class="contact-form-subject">
							<input type="text" name="contactSubject" id="contactSubject" class="input-text" value="<?php if( $subject_s ) { echo esc_html( $subject_s ); } else { echo __('Subject', 'lbprojects'); } ?>" />
							<label for="contactSubject"><i class="icon-star icon-large"></i></label>
						</p>
						
						<p class="contact-form-message">
							<textarea name="contactMessage" id="contactMessage" rows="10" cols="40"><?php echo esc_html( $message_s ); ?></textarea>
						</p>
						
						<p><button id="contactSubmit" type="submit"><i class="icon-ok"></i><?php _e('Submit Email', 'lbprojects'); ?></button></p>
						
						<input type="hidden" name="submitted" id="submitted" value="true" />
						
						<?php 
						if(isset($hasError)) {
							echo '<p id="contactError">' . __('Your Message could not be submitted. Please check your input.', 'lbprojects') . '</p>';
						}
						
						if(isset($emailSent)) {
							echo '<p id="contactSuccess">' . __('Your message has been submitted successfully.', 'lbprojects') . '</p>';
						} 
						?>
						
					</form>

				</div><!-- entry -->		
				
			</div><!-- article -->

		</div><!-- post -->
			
		<?php endwhile; endif; ?>

	</div><!-- article-wrapper -->		

	<?php comments_template(); ?>  

	</div><!-- content -->

	<?php get_sidebar(); ?>            
                
	</div><!-- main -->

	</div><!-- wrapper -->

<?php get_footer(); ?>
<?php

/*
*	functions.php
*	Featured Post Slider meta options
*/

// Add Meta Box
function LB_featured_post_add() {
	add_meta_box( 'LB-featured-post-id', __('Featured Post', 'lbprojects'), 'LB_featured_post_callback', 'post', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'LB_featured_post_add' );


// Create Meta Box Options
function LB_featured_post_callback( $post ) {

	$values = get_post_custom( $post->ID );
	$check = isset( $values['LB-featured-post-check'] ) ? esc_attr( $values['LB-featured-post-check'][0] ) : '';
	$text = isset( $values['LB-featured-post-text'] ) ? esc_attr( $values['LB-featured-post-text'][0] ) : '';
	wp_nonce_field( 'LB-featured-post-nonce', 'meta_box_nonce' );
	?>
	
	<p>
		<input type="checkbox" name="LB-featured-post-check" id="LB-featured-post-check" <?php checked( $check, 1 ); ?> />
		<label for="LB-featured-post-check"><?php _e('Display post in the featured post slider on the homepage.', 'lbprojects'); ?></label>
	</p>
	
	<p>  
		<label for="LB-featured-post-text"><?php _e('Custom Title:', 'lbprojects'); ?></label>
		<input type="text" class="widefat" name="LB-featured-post-text" id="LB-featured-post-text" value="<?php echo $text; ?>" /> 
	</p>
	
	<?php	
}


// Validate and save the meta data
function LB_featured_post_save( $post_id ) {

	// Options for validation
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

	if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'LB-featured-post-nonce' ) ) return;

	if( !current_user_can( 'edit_post' ) ) return;
	
	$allowed = array( 'a' => array( 'href' => array() ) );
	
	// Save meta data
	if( isset( $_POST['LB-featured-post-text'] ) )
	update_post_meta( $post_id, 'LB-featured-post-text', wp_kses( $_POST['LB-featured-post-text'], $allowed ) );

	$chk = ( isset( $_POST['LB-featured-post-check'] ) && $_POST['LB-featured-post-check'] ) ? 1 : 0;
	update_post_meta( $post_id, 'LB-featured-post-check', $chk );
	
}
add_action( 'save_post', 'LB_featured_post_save' );

?>
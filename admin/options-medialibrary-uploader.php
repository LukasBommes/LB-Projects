<?php
// WooThemes Media Library-driven AJAX File Uploader Module
if( is_admin() ) {	
	// Load additional css and js for image uploads on the Options Framework page
	$of_page= 'appearance_page_options-framework';
	add_action( "admin_print_styles-$of_page", 'optionsframework_mlu_css', 0 );
	add_action( "admin_print_scripts-$of_page", 'optionsframework_mlu_js', 0 );	
}

// Sets up a custom post type to attach image to
if( !function_exists( 'optionsframework_mlu_init' ) ) {
	function optionsframework_mlu_init() {
		register_post_type( 'optionsframework', array(
			'labels' => array( 'name' => __( 'Theme Options Media', 'lbprojects' ) ),
			'public' => true,
			'show_ui' => false,
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => false,
			'supports' => array( 'title', 'editor' ), 
			'query_var' => false,
			'can_export' => true,
			'show_in_nav_menus' => false,
			'public' => false
		) );
	}
}

// Adds the Thickbox CSS file and specific loading and button images to the header on the pages where this function is called
if( !function_exists( 'optionsframework_mlu_css' ) ) {
	function optionsframework_mlu_css() {	
		$_html = '';
		$_html .= '<link rel="stylesheet" href="' . site_url() . '/' . WPINC . '/js/thickbox/thickbox.css" type="text/css" media="screen" />' . "\n";
		$_html .= '<script type="text/javascript">
		var tb_pathToImage = "' . site_url() . '/' . WPINC . '/js/thickbox/loadingAnimation.gif";
	    var tb_closeImage = "' . site_url() . '/' . WPINC . '/js/thickbox/tb-close.png";
	    </script>' . "\n";	    
	    echo $_html;		
	}
}

// Registers and enqueues the necessary Javascript file for working with the Media Library-driven AJAX File Uploader Module
if( !function_exists( 'optionsframework_mlu_js' ) ) {
	function optionsframework_mlu_js() {	
		// Registers custom scripts for the Media Library AJAX uploader.
		wp_register_script( 'of-medialibrary-uploader', OPTIONS_FRAMEWORK_DIRECTORY .'js/of-medialibrary-uploader.js', array( 'jquery', 'thickbox' ) );
		wp_enqueue_script( 'of-medialibrary-uploader' );
		wp_enqueue_script( 'media-upload' );
	}
}

// Media Uploader Using the WordPress Media Library
if( !function_exists( 'optionsframework_medialibrary_uploader' ) ) {

	function optionsframework_medialibrary_uploader( $_id, $_value, $_mode = 'full', $_desc = '', $_postid = 0, $_name = '') {
	
		$optionsframework_settings = get_option('optionsframework');
		
		// Gets the unique option id
		$option_name = $optionsframework_settings['id'];
	
		$output = '';
		$id = '';
		$class = '';
		$int = '';
		$value = '';
		$name = '';
		
		$id = strip_tags( strtolower( $_id ) );
		// Change for each field, using a "silent" post. If no post is present, one will be created.
		$int = optionsframework_mlu_get_silentpost( $id );
		
		// If a value is passed and we don't have a stored value, use the value that's passed through.
		if( $_value != '' && $value == '' ) {
			$value = $_value;
		}
		
		if($_name != '') {
			$name = $option_name.'['.$id.']['.$_name.']';
		}
		else {
			$name = $option_name.'['.$id.']';
		}
		
		if( $value ) { $class = ' has-file'; }
		$output .= '<input id="' . $id . '" class="upload' . $class . '" type="text" name="'.$name.'" value="' . $value . '" />' . "\n";
		$output .= '<input id="upload_' . $id . '" class="upload_button button" type="button" value="' . __( 'Upload', 'lbprojects' ) . '" rel="' . $int . '" />' . "\n";
		
		if( $_desc != '' ) {
			$output .= '<span class="of_metabox_desc">' . $_desc . '</span>' . "\n";
		}
		
		$output .= '<div class="screenshot" id="' . $id . '_image">' . "\n";
		
		if( $value != '' ) { 
			$remove = '<a href="javascript:(void);" class="mlu_remove button">Remove</a>';
			$image = preg_match( '/(^.*\.jpg|jpeg|png|gif|ico*)/i', $value );
			if( $image ) {
				$output .= '<img src="' . $value . '" alt="" />'.$remove.'';
			} else {
				$parts = explode( "/", $value );
				for( $i = 0; $i < sizeof( $parts ); ++$i ) {
					$title = $parts[$i];
				}

				// No output preview if it's not an image.			
				$output .= '';
			
				// Standard generic output if it's not an image.	
				$title = __( 'View File', 'lbprojects' );
				$output .= '<div class="no_image"><span class="file_link"><a href="' . $value . '" target="_blank" rel="external">'.$title.'</a></span>' . $remove . '</div>';
			}	
		}
		$output .= '</div>' . "\n";
		return $output;
	}	
}

// Uses hidden posts in the database to store relationships for images
if( !function_exists( 'optionsframework_mlu_get_silentpost' ) ) {

	function optionsframework_mlu_get_silentpost( $_token ) {
	
		global $wpdb;
		$_id = 0;		
		$_token = strtolower( str_replace( ' ', '_', $_token ) );
		
		if( $_token ) {
			
			// Tell the function what to look for in a post			
			$_args = array( 'post_type' => 'optionsframework', 'post_name' => 'of-' . $_token, 'post_status' => 'draft', 'comment_status' => 'closed', 'ping_status' => 'closed' );
			
			// Look in the database for a "silent" post that meets our criteria
			$query = 'SELECT ID FROM ' . $wpdb->posts . ' WHERE post_parent = 0';
			foreach ( $_args as $k => $v ) {
				$query .= ' AND ' . $k . ' = "' . $v . '"';
			}
			
			$query .= ' LIMIT 1';
			$_posts = $wpdb->get_row( $query );
			
			// If we've got a post, loop through and get it's ID
			if( count( $_posts ) ) {
				$_id = $_posts->ID;
			} else {
			
				// If no post is present, insert one
				$_words = explode( '_', $_token );
				$_title = join( ' ', $_words );
				$_title = ucwords( $_title );
				$_post_data = array( 'post_title' => $_title );
				$_post_data = array_merge( $_post_data, $_args );
				$_id = wp_insert_post( $_post_data );
			}	
		}
		return $_id;
	}
}

// Enqueue Javascript file to modifiy content of the media upload box
if( !function_exists( 'optionsframework_mlu_js_popup' ) ) {

	function optionsframework_mlu_js_popup() {	
		wp_enqueue_script('medialibrary-customizer', OPTIONS_FRAMEWORK_DIRECTORY . 'js/medialibrary-customizer.js', array('jquery'));
	}
	add_action( 'admin_head', 'optionsframework_mlu_js_popup' );	
}

// Triggered inside the Media Library popup to modify the title of the Gallery tab
if( !function_exists( 'optionsframework_mlu_modify_tabs' ) ) {

	function optionsframework_mlu_modify_tabs( $tabs ) {
		if( isset( $tabs['gallery'] ) ) {
			$tabs['gallery'] = str_replace( __( 'Gallery', 'lbprojects' ), __( 'Previously Uploaded', 'lbprojects' ), $tabs['gallery'] );
		}		
		return $tabs;
	}
	add_filter( 'media_upload_tabs', 'optionsframework_mlu_modify_tabs' );	
}
?>
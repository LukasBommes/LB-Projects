<?php
// Check user capabilities and initialize options framework
function optionsframework_rolescheck () {
	if ( current_user_can( 'edit_theme_options' ) ) {
		add_action( 'admin_menu', 'optionsframework_add_page');
		add_action( 'admin_init', 'optionsframework_init' );
		add_action( 'admin_init', 'optionsframework_mlu_init' );
		add_action( 'wp_before_admin_bar_render', 'optionsframework_adminbar' );
	}
}
add_action('init', 'optionsframework_rolescheck' );

// Loads the file for option sanitization
function optionsframework_load_sanitization() {
	require_once dirname( __FILE__ ) . '/options-sanitize.php';
}
add_action('init', 'optionsframework_load_sanitization' );

// Init options framework
function optionsframework_init() {

	// Include the required files
	require_once dirname( __FILE__ ) . '/options-interface.php';
	require_once dirname( __FILE__ ) . '/options-medialibrary-uploader.php';
	
	// Loads the options array from the theme
	if ( $optionsfile = locate_template( array('options.php') ) ) {
		require_once $optionsfile;
	}
	else if (file_exists( dirname( __FILE__ ) . '/options.php' ) ) {
		require_once dirname( __FILE__ ) . '/options.php';
	}
	
	$optionsframework_settings = get_option('optionsframework' );
	
	// Updates the unique option id in the database if it has changed
	optionsframework_option_name();
	
	// Gets the unique id, returning a default if it isn't defined
	if ( isset($optionsframework_settings['id']) ) {
		$option_name = $optionsframework_settings['id'];
	}
	else {
		$option_name = 'optionsframework';
	}
	
	// If the option has no saved data, load the defaults
	if ( ! get_option($option_name) ) {
		optionsframework_setdefaults();
	}
	
	// Registers the settings fields and callback
	register_setting( 'optionsframework', $option_name, 'optionsframework_validate' );
	
	// Change the capability required to save the 'optionsframework' options group.
	add_filter( 'option_page_capability_optionsframework', 'optionsframework_page_capability' );
}

function optionsframework_page_capability( $capability ) {
	return 'edit_theme_options';
}

// Set default values
function optionsframework_setdefaults() {
	
	$optionsframework_settings = get_option('optionsframework');

	// Gets the unique option id
	$option_name = $optionsframework_settings['id'];
	
	if ( isset($optionsframework_settings['knownoptions']) ) {
		$knownoptions =  $optionsframework_settings['knownoptions'];
		if ( !in_array($option_name, $knownoptions) ) {
			array_push( $knownoptions, $option_name );
			$optionsframework_settings['knownoptions'] = $knownoptions;
			update_option('optionsframework', $optionsframework_settings);
		}
	} else {
		$newoptionname = array($option_name);
		$optionsframework_settings['knownoptions'] = $newoptionname;
		update_option('optionsframework', $optionsframework_settings);
	}
	
	// Gets the default options data from the array in options.php
	$options = optionsframework_options();
	
	// If the options haven't been added to the database yet, they are added now
	$values = of_get_default_values();
	
	if ( isset($values) ) {
		add_option( $option_name, $values ); // Add option with default settings
	}
}

// Add subpage to the appearance menu.
if ( !function_exists( 'optionsframework_add_page' ) ) {
	function optionsframework_add_page() {
		$of_page = add_theme_page(__('Theme Options', 'lbprojects'), __('Theme Options', 'lbprojects'), 'edit_theme_options', 'options-framework','optionsframework_page');
		
		// Load the required CSS and javscript
		add_action('admin_enqueue_scripts', 'optionsframework_load_scripts');
		add_action( 'admin_print_styles-' . $of_page, 'optionsframework_load_styles' );
	}	
}

// Load the CSS
function optionsframework_load_styles() {
	wp_enqueue_style('optionsframework', OPTIONS_FRAMEWORK_DIRECTORY.'css/optionsframework.css');
	wp_enqueue_style('color-picker', OPTIONS_FRAMEWORK_DIRECTORY.'css/colorpicker.css');
}	

// Loads the javascript
function optionsframework_load_scripts($hook) {

	if ( 'appearance_page_options-framework' != $hook ) {
        return;
	}
	
	// Enqueued scripts
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('color-picker', OPTIONS_FRAMEWORK_DIRECTORY.'js/colorpicker.js', array('jquery'));
	wp_enqueue_script('options-custom', OPTIONS_FRAMEWORK_DIRECTORY.'js/options-custom.js', array('jquery'));
	
	// Inline scripts from options-interface.php
	add_action('admin_head', 'of_admin_head');
}

function of_admin_head() {
	do_action( 'optionsframework_custom_scripts' );
}

// Creating the options panel
if ( !function_exists( 'optionsframework_page' ) ) {
	function optionsframework_page() {
		settings_errors();
?>

	<div id="optionsframework-wrap" class="wrap">
    <?php screen_icon( 'themes' ); ?>
    <h2 class="nav-tab-wrapper">
        <?php echo optionsframework_tabs(); ?>
    </h2>

    <div id="optionsframework-metabox" class="metabox-holder">
	    <div id="optionsframework" class="postbox">
			<form action="options.php" method="post">
			<?php settings_fields('optionsframework'); ?>
			<?php optionsframework_fields(); /* Settings */ ?>
			<div id="optionsframework-submit">
				<input type="submit" class="button-primary" name="update" value="<?php esc_attr_e( 'Save Options', 'lbprojects' ); ?>" />
				<input type="submit" class="reset-button button-secondary" name="reset" value="<?php esc_attr_e( 'Restore Defaults', 'lbprojects' ); ?>" onclick="return confirm( '<?php print esc_js( __( 'Click OK to reset. Any theme settings will be lost!', 'lbprojects' ) ); ?>' );" />
				<div class="clear"></div>
			</div>
			</form>
		</div> <!-- container -->
	</div>
	<?php do_action('optionsframework_after'); ?>
	</div> <!-- wrap -->
	
<?php
	}
}

// Validate Options
function optionsframework_validate( $input ) {

	// Restore Defaults.
	if ( isset( $_POST['reset'] ) ) {
		add_settings_error( 'options-framework', 'restore_defaults', __( 'Default options restored.', 'lbprojects' ), 'updated fade' );
		return of_get_default_values();
	}
	// Update Settings
	else {
		$clean = array();
		$options = optionsframework_options();
		foreach ( $options as $option ) {

			if ( ! isset( $option['id'] ) ) {
				continue;
			}
			if ( ! isset( $option['type'] ) ) {
				continue;
			}

			$id = preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $option['id'] ) );

			// Set checkbox to false if it wasn't sent in the $_POST
			if ( 'checkbox' == $option['type'] && ! isset( $input[$id] ) ) {
				$input[$id] = false;
			}

			// Set each item in the multicheck to false if it wasn't sent in the $_POST
			if ( 'multicheck' == $option['type'] && ! isset( $input[$id] ) ) {
				foreach ( $option['options'] as $key => $value ) {
					$input[$id][$key] = false;
				}
			}

			// For a value to be submitted to database it must pass through a sanitization filter
			if ( has_filter( 'of_sanitize_' . $option['type'] ) ) {
				$clean[$id] = apply_filters( 'of_sanitize_' . $option['type'], $input[$id], $option );
			}
		}

		add_settings_error( 'options-framework', 'save_options', __( 'Options saved.', 'lbprojects' ), 'updated fade' );
		return $clean;
	}

}

// Format Configuration Array 
function of_get_default_values() {
	$output = array();
	$config = optionsframework_options();
	foreach ( (array) $config as $option ) {
		if ( ! isset( $option['id'] ) ) {
			continue;
		}
		if ( ! isset( $option['std'] ) ) {
			continue;
		}
		if ( ! isset( $option['type'] ) ) {
			continue;
		}
		if ( has_filter( 'of_sanitize_' . $option['type'] ) ) {
			$output[$option['id']] = apply_filters( 'of_sanitize_' . $option['type'], $option['std'], $option );
		}
	}
	return $output;
}

// Add Theme Options menu item to Admin Bar
function optionsframework_adminbar() {
	global $wp_admin_bar;
	$wp_admin_bar->add_menu( array(
			'parent' => 'appearance',
			'id' => 'of_theme_options',
			'title' => __( 'Theme Options', 'lbprojects' ),
			'href' => admin_url( 'themes.php?page=options-framework' )
	));
}

if ( ! function_exists( 'of_get_option' ) ) {

	// Helper function to return the theme option value
	function of_get_option( $name, $default = false ) {
		$config = get_option( 'optionsframework' );

		if ( ! isset( $config['id'] ) ) {
			return $default;
		}

		$options = get_option( $config['id'] );

		if ( isset( $options[$name] ) ) {
			return $options[$name];
		}

		return $default;
	}
}
?>
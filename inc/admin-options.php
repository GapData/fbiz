<?php
/**
 * fBiz Theme Options Functionality
 *
 * @package WordPress
 * @subpackage fBiz
 * @author tishonator
 * @since fBiz 1.0.0
 */

/******************************
  Admin Page Functions
******************************/
function fbiz_menu() {
	add_theme_page( __( 'Theme Options', 'fbiz' ), __( 'Theme Options', 'fbiz' ),
		fbiz_get_options_page_cap(), 'options.php', 'fbiz_page' );
}
add_action( 'admin_menu', 'fbiz_menu' );

function fbiz_get_options_page_cap() {
    return 'edit_theme_options';
}
add_filter( 'option_page_capability_fbiz-options', 'fbiz_get_options_page_cap' );


/******************************
  Callback function to the add_theme_page. It displays the theme options page
******************************/
function fbiz_get_option_defaults() {

	$defaults = array(
		'header_logo'           => get_template_directory_uri().'/img/logo.png',
		'slider_slide1_content' => __( '<h2>Lorem ipsum dolor</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><a class="btn" title="Read more" href="#">Read more</a>', 'fbiz' ),
		'slider_slide1_image'	=> get_template_directory_uri().'/img/1.jpg',
		'slider_slide2_content' => __( '<h2>Everti Constituam</h2><p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><a class="btn" title="Read more" href="#">Read more</a>', 'fbiz' ),
		'slider_slide2_image'	=> get_template_directory_uri().'/img/2.jpg',		
		'slider_slide3_content' => __( '<h2>Id Essent Cetero</h2><p>Quodsi docendi sed id. Ea eam quod aliquam epicurei, qui tollit inimicus partiendo cu ei. Nisl consul expetendis at duo, mea ea ceteros constituam.</p><a class="btn" title="Read more" href="#">Read more</a>', 'fbiz' ),
		'slider_slide3_image' 	=> get_template_directory_uri().'/img/3.jpg',
	);

	return apply_filters( 'fbiz_get_option_defaults', $defaults );
}

function fbiz_get_options() {
    // Options API
    return wp_parse_args( 
        get_option( 'theme_fbiz_options', array() ), 
        fbiz_get_option_defaults() 
    );
}

function fbiz_page() {
	$fullThemeUrl = "http://tishonator.com/product/tbiz";
?>
    <div class="wrap">
		<h2>
			<?php _e( 'Theme Options', 'fbiz' ) ?>
		</h2>
		<div class="manage-menus">
			<?php _e( 'The fBiz theme is a free version of the profession and multi-purpose theme tBiz.', 'fbiz' ); ?> <a href="<?php echo esc_url( $fullThemeUrl ); ?>" title="<?php esc_attr_e( 'Click Here', 'fbiz' ); ?>"><?php _e( 'Click Here', 'fbiz' ); ?></a> <?php _e( 'to learn more about tBiz theme.', 'fbiz' ); ?>
		</div>
		<?php if (isset($_GET[ 'settings-updated' ])) : ?>
					<div class='updated'>
						<p>
							<?php _e( 'Theme settings updated successfully.', 'fbiz' ) ?>
						</p>
					</div>
		<?php endif; ?>

		<form method="post" enctype="multipart/form-data" action="options.php">
			<?php
				settings_fields( 'fbiz_settings' );
				do_settings_sections( 'fbiz_settings' );
			?>
			
			<p class="submit">  
				<input type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'fbiz' ) ?>" /> <a href="<?php echo esc_url( $fullThemeUrl ); ?>" title="<?php esc_attr_e( 'Upgrade to tBiz Theme', 'fbiz' ); ?>" class="button-primary"><?php _e( 'Upgrade to tBiz Theme', 'fbiz' ); ?></a>
			</p>
		</form>
    </div>
<?php
}

function fbiz_register_settings() {

	register_setting( 'fbiz_settings', 'theme_fbiz_options', 'fbiz_sanitize_callback' );
	
	add_settings_section( 'fbiz_options_section', __( 'Settings', 'fbiz' ),
						  'fbiz_display_settings_section', 'fbiz_settings' );
						  
	/**
   	 * add logo image
	 */
	$field_args = array( 'type'        => 'image',
						 'id'          => 'header_logo',
						 'name'        => 'header_logo',
						 'desc'        => __( 'Upload a custom logo for your website.', 'fbiz' ),
						 'std'         => '',
						 'label_for'   => 'header_logo',
						 'option_name' => 'theme_fbiz_options',
					   );

	add_settings_field( 'header_logo_image', __( 'Logo image', 'fbiz' ), 'fbiz_display_setting',
				'fbiz_settings', 'fbiz_options_section', $field_args );
	
	/**
     * add footer copyright text
	 */
	$field_args = array( 'type'        => 'text',
						 'id'          => 'footer_copyrighttext',
						 'name'        => 'footer_copyrighttext',
						 'desc'        => __( 'Your Copyright text to appear in the website footer', 'fbiz' ),
						 'std'         => '',
						 'label_for'   => 'footer_copyrighttext',
						 'option_name' => 'theme_fbiz_options',
					   );

	add_settings_field( 'footer_copyrighttext_text', __( 'Copyright Text', 'fbiz' ), 'fbiz_display_setting',
				'fbiz_settings', 'fbiz_options_section', $field_args );
	
	/**
	 * add slider #1 content
	 */
	$field_args = array( 'type'    => 'textarea',
					 'id'          => 'slider_slide1_content',
					 'name'        => 'slider_slide1_content',
					 'desc'        => sprintf( __( 'Slide #%s content in the slider', 'fbiz' ), 1 ),
					 'std'         => '',
					 'label_for'   => 'slider_slide1_content',
					 'option_name' => 'theme_fbiz_options',
				   );

	add_settings_field( 'slider_slide1_content_textarea', sprintf( __( 'Slide #%s Content', 'fbiz' ), 1 ), 'fbiz_display_setting',
			'fbiz_settings', 'fbiz_options_section', $field_args );

	/**
	 * add slider #1 image
	 */
	$field_args = array( 'type'    => 'image',
					 'id'          => 'slider_slide1_image',
					 'name'        => 'slider_slide1_image',
					 'desc'        => sprintf( __( 'Upload a custom Slide #%s Background image for the slider.', 'fbiz' ), 1 ),
					 'std'         => '',
					 'label_for'   => 'slider_slide1_image',
					 'option_name' => 'theme_fbiz_options',
				   );

	add_settings_field( 'slider_slide1_image_image', sprintf( __( 'Slide #%s Background Image', 'fbiz' ), 1 ), 'fbiz_display_setting',
			'fbiz_settings', 'fbiz_options_section', $field_args );
	
	/**
	 * add slider #2 content
	 */
	$field_args = array( 'type'    => 'textarea',
					 'id'          => 'slider_slide2_content',
					 'name'        => 'slider_slide2_content',
					 'desc'        => sprintf( __( 'Slide #%s content in the slider', 'fbiz' ), 2 ),
					 'std'         => '',
					 'label_for'   => 'slider_slide2_content',
					 'option_name' => 'theme_fbiz_options',
				   );

	add_settings_field( 'slider_slide2_content_textarea', sprintf( __( 'Slide #%s Content', 'fbiz' ), 2 ), 'fbiz_display_setting',
			'fbiz_settings', 'fbiz_options_section', $field_args );

	/**
	 * add slider #1 image
	 */
	$field_args = array( 'type'    => 'image',
					 'id'          => 'slider_slide2_image',
					 'name'        => 'slider_slide2_image',
					 'desc'        => sprintf( __( 'Upload a custom Slide #%s Background image for the slider.', 'fbiz' ), 2 ),
					 'std'         => '',
					 'label_for'   => 'slider_slide2_image',
					 'option_name' => 'theme_fbiz_options',
				   );

	add_settings_field( 'slider_slide2_image_image', sprintf( __( 'Slide #%s Background Image', 'fbiz' ), 2 ), 'fbiz_display_setting',
			'fbiz_settings', 'fbiz_options_section', $field_args );
	
	/**
	 * add slider #3 content
	 */
	$field_args = array( 'type'        => 'textarea',
					 'id'          => 'slider_slide3_content',
					 'name'        => 'slider_slide3_content',
					 'desc'        => sprintf( __( 'Slide #%s content in the slider', 'fbiz' ), 3 ),
					 'std'         => '',
					 'label_for'   => 'slider_slide3_content',
					 'option_name' => 'theme_fbiz_options',
				   );

	add_settings_field( 'slider_slide3_content_textarea', sprintf( __( 'Slide #%s Content', 'fbiz' ), 3 ), 'fbiz_display_setting',
			'fbiz_settings', 'fbiz_options_section', $field_args );

	/**
	 * add slider #3 image
	 */
	$field_args = array( 'type'    => 'image',
					 'id'          => 'slider_slide3_image',
					 'name'        => 'slider_slide3_image',
					 'desc'        => sprintf( __( 'Upload a custom Slide #%s Background image for the slider.', 'fbiz' ), 3 ),
					 'std'         => '',
					 'label_for'   => 'slider_slide3_image',
					 'option_name' => 'theme_fbiz_options',
				   );

	add_settings_field( 'slider_slide3_image_image', sprintf( __( 'Slide #%s Background Image', 'fbiz' ), 3 ), 'fbiz_display_setting',
			'fbiz_settings', 'fbiz_options_section', $field_args );
}
add_action( 'admin_init', 'fbiz_register_settings' );

/**
 * Function to add extra text to display on each section
 */
function fbiz_display_settings_section() {
}

/**
 * Function to display the settings on the page
 * This is setup to be expandable by using a switch on the type variable.
 * In future you can add multiple types to be display from this function,
 * Such as checkboxes, select boxes, file upload boxes etc.
 */
 $sendToEditorAdded = false;
function fbiz_display_setting( $args ) {

	extract( $args );

    $options = fbiz_get_options();
	
	if ( array_key_exists( $id, $options ) ) {
	
		$options[$id] = stripslashes( $options[$id] );  
        $options[$id] = esc_attr( $options[$id] );
	}
	
	$optionsId = ( $options !== false && array_key_exists( $id, $options ) )
							? $options[ $id ] : '';
				
    switch ( $type ) {
		case 'url':
              echo "<input class='regular-text' type='url' id='" .  esc_attr($id) . "' name='" .  esc_attr($option_name) . "[$id]' value='" .  esc_attr( $optionsId ) . "' />";  
              echo ( $desc != '' ) ? "<br /><span class='description'>$desc</span>" : "";  
          break;
          case 'text':
              echo "<input class='regular-text' type='text' id='" .  esc_attr($id) . "' name='" .  esc_attr($option_name) . "[$id]' value='" .  esc_attr( $optionsId ) . "' />";  
              echo ( $desc != '' ) ? "<br /><span class='description'>$desc</span>" : "";  
          break;
		  
		  case 'textarea':    
              echo "<textarea rows='4' cols='50' id='" .  esc_attr( $id ) . "' name='" .  esc_attr( $option_name ) . "[" .  esc_attr( $id ) . "]'>" . esc_attr( $optionsId ) . '</textarea>';  
              echo ( $desc != '' ) ? "<br /><span class='description'>$desc</span>" : "";  
          break;
		  
		  case 'image':		  
		  	  echo "<input type='url' id='" .  esc_attr( $id ) . "' name='" .  esc_attr( $option_name ) . "[" . esc_attr( $id ) . "]' value='" .  esc_attr( $optionsId ) . "' class='regular-text' />";  
        	  echo '<input id="'.$id.'_uploadBtn" type="button" value="'.__( 'Upload', 'fbiz' ).'" />';
			  echo ($desc != '' ) ? "<br /><span class='description'>$desc</span>" : "";
			  if ( $optionsId != '' ) {			  
			  	echo '<br /><p><img id="' . esc_attr( $id ) . '_preview" src="' .  esc_attr( $optionsId ) . '" /></p>';
			  }
		  break;
    }
}

/**
 * This function is used to load all of the necessary styles and scripts used in admin
 */
function fbiz_settings_enqueue_scripts() {

	wp_enqueue_script( 'thickbox' );
    wp_enqueue_style( 'thickbox' );
    wp_enqueue_script( 'media-upload' );
    wp_enqueue_script( 'wptuts-upload' );
	wp_enqueue_style( 'wp-color-picker' );

	wp_register_script( 'fbiz-admin-utilities-js', get_template_directory_uri() . '/js/admin-utilities.js', array( 'jquery', 'wp-color-picker' ) );

	$translation_array = array( 'upload_image' => __( 'Upload an image', 'fbiz') );
	
	wp_localize_script( 'fbiz-admin-utilities-js', 'translation_array', $translation_array );
	
	wp_enqueue_script( 'fbiz-admin-utilities-js' );
}
add_action( 'admin_print_scripts-appearance_page_options', 'fbiz_settings_enqueue_scripts' );

/**
 * Sanitized the input values before storing to database
 */
function fbiz_sanitize_callback($input) {

	foreach ( $input as $k => $v ) {
	
		$val = trim($v);
		
		switch ($k) {
			case 'header_logo':
				$newinput[$k] = esc_url_raw( $val );			
				break;
			case 'footer_copyrighttext':
				$newinput[$k] = sanitize_text_field( $val );			
				break;
			case 'slider_slide1_content':
				$newinput[$k] = force_balance_tags( $val );			
				break;	
			case 'slider_slide1_image':
				$newinput[$k] = esc_url_raw( $val );			
				break;	
			case 'slider_slide2_content':
				$newinput[$k] = force_balance_tags( $val );			
				break;	
			case 'slider_slide2_image':
				$newinput[$k] = esc_url_raw( $val );			
				break;	
			case 'slider_slide3_content':
				$newinput[$k] = force_balance_tags( $val );			
				break;
			case 'slider_slide3_image':
				$newinput[$k] = esc_url_raw( $val );			
				break;
			default:
				$newinput[$k] = $val;
				break;
		}
	}

	return $newinput;
}

?>
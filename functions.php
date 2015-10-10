<?php
/**
 * fBiz functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage fBiz
 * @author tishonator
 * @since fBiz 1.0.0
 *
 */

if ( ! function_exists( 'fbiz_setup' ) ) :
/**
 * fBiz setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 *
 */
function fbiz_setup() {

	load_theme_textdomain( 'fbiz', get_template_directory() . '/languages' );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary'   => __( 'primary menu', 'fbiz' ),
	) );

	// Add wp_enqueue_scripts actions
	add_action( 'wp_enqueue_scripts', 'fbiz_load_scripts' );

	add_action( 'widgets_init', 'fbiz_widgets_init' );

	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 'full', 'full', true );

	if ( ! isset( $content_width ) )
		$content_width = 900;

	add_theme_support( 'automatic-feed-links' );

	// add Custom background				 
	add_theme_support( 'custom-background', 
				   array ('default-color'  => '#FFFFFF')
				 );

	// add custom header
	add_theme_support( 'custom-header', array (
					   'default-image'          => '',
					   'random-default'         => false,
					   'width'                  => 0,
					   'height'                 => 0,
					   'flex-height'            => false,
					   'flex-width'             => false,
					   'default-text-color'     => '',
					   'header-text'            => true,
					   'uploads'                => true,
					   'wp-head-callback'       => '',
					   'admin-head-callback'    => '',
					   'admin-preview-callback' => '',
					) );
					
	add_theme_support( "title-tag" );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list',
	) );

	// add support for Post Formats.
	add_theme_support( 'post-formats', array (
											'aside',
											'image',
											'video',
											'audio',
											'quote', 
											'link',
											'gallery',
					) );

	// add the visual editor to resemble the theme style
	add_editor_style( array( 'css/editor-style.css' ) );
}
endif; // fbiz_setup
add_action( 'after_setup_theme', 'fbiz_setup' );

/**
 * the main function to load scripts in the fBiz theme
 * if you add a new load of script, style, etc. you can use that function
 * instead of adding a new wp_enqueue_scripts action for it.
 */
function fbiz_load_scripts() {

	// load main stylesheet.
	wp_enqueue_style( 'fbiz-style', get_stylesheet_uri(), array( ) );
	
	wp_enqueue_style( 'fbiz-fonts', fbiz_fonts_url(), array(), null );
	
	// Load thread comments reply script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
	
	// Load Utilities JS Script
	wp_enqueue_script( 'fbiz-utilities-js', get_template_directory_uri() . '/js/utilities.js', array( 'jquery' ) );
	
	// Load script for the slider
	wp_enqueue_script( 'tisho-slider-js', get_template_directory_uri() . '/js/unslider.js', array( 'jquery' ) );
}

/**
 *	Load google font url used in the fBiz theme
 */
function fbiz_fonts_url() {

    $fonts_url = '';
 
    /* Translators: If there are characters in your language that are not
    * supported by Cantarell, translate this to 'off'. Do not translate
    * into your own language.
    */
    $cantarell = _x( 'on', 'Cantarell font: on or off', 'fbiz' );

    if ( 'off' !== $cantarell ) {
        $font_families = array();
 
        $font_families[] = 'Cantarell:400,700';
 
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );
 
        $fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
    }
 
    return $fonts_url;
}

/**
 *	widgets-init action handler. Used to register widgets and register widget areas
 */
function fbiz_widgets_init() {

	// Sidebar Widget.
	register_sidebar( array (
						'name'	 		 =>	 __( 'Sidebar Widget Area', 'fbiz'),
						'id'		 	 =>	 'sidebar-widget-area',
						'description'	 =>  __( 'The sidebar widget area', 'fbiz'),
						'before_widget'	 =>  '',
						'after_widget'	 =>  '',
						'before_title'	 =>  '<div class="sidebar-before-title"></div><h3 class="sidebar-title">',
						'after_title'	 =>  '</h3><div class="sidebar-after-title"></div>',
					) );
	
	/**
	 * Add Homepage Columns Widget areas
	 */
	for ($i = 1; $i <= 3; ++$i) {

		// Add Homepage Column #i Widget
		register_sidebar( array (
							'name'			 =>  sprintf( __( 'Homepage Column #%s', 'fbiz' ), $i ),
							'id' 			 =>  'homepage-column-'.$i.'-widget-area',
							'description'	 =>  sprintf( __( 'The Homepage Column #%s widget area', 'fbiz' ), $i ),
							'before_widget'  =>  '',
							'after_widget'	 =>  '',
							'before_title'	 =>  '<h2 class="sidebar-title">',
							'after_title'	 =>  '</h2><div class="sidebar-after-title"></div>',
						) );					
	}
}

/**
 *	Displays the copyright text.
 */
function fbiz_show_copyright_text() {
	
	$footerText = get_theme_mod('fbiz_footer_copyright', null);

	if ( !empty( $footerText ) ) {

		echo esc_html( $footerText ) . ' | ';		
	}
}

/**
 * Displays the Page Header Section including Page Title and Breadcrumb
 */
function fbiz_show_page_header_section() { 
	global $paged, $page;

	if ( is_single() || is_page() ) :
        $title = single_post_title( '', false );

	elseif ( is_home() ) :
		if ( $paged >= 2 || $page >= 2 ) :
			$title = sprintf( __( '%s - Page %s', 'fbiz' ), single_post_title( '', false ), max( $paged, $page ) );	
		else :
			$title = single_post_title( '', false );	
		endif;
		
	elseif ( is_404() ) :
		$title = __( 'Error 404: Not Found', 'fbiz' );
		
	else :
	
		/**
		 * we use get_the_archive_title() to get the title of the archive of 
		 * a category (taxonomy), tag (term), author, custom post type, post format, date, etc.
		 */
		$title = get_the_archive_title();
		
	endif;
	
	?>

	<section id="page-header">
		<div id="page-header-content">

			<h1><?php echo $title; ?></h1>

			<div class="clear">
			</div>
		</div>
    </section>
<?php
}

/**
 * Display website's logo image
 */
function fbiz_show_website_logo_image_or_title() {

	if ( get_header_image() != '' ) {
	
		// Check if the user selected a header Image in the Customizer or the Header Menu
		$logoImgPath = get_header_image();
		$siteTitle = get_bloginfo( 'name' );
		$imageWidth = get_custom_header()->width;
		$imageHeight = get_custom_header()->height;
		
		echo '<a href="' . esc_url( home_url('/') ) . '" title="' . esc_attr( get_bloginfo('name') ) . '">';
		
		echo '<img src="' . esc_attr( $logoImgPath ) . '" alt="' . esc_attr( $siteTitle ) . '" title="' . esc_attr( $siteTitle ) . '" width="' . esc_attr( $imageWidth ) . '" height="' . esc_attr( $imageHeight ) . '" />';
		
		echo '</a>';

	} else {
	
		echo '<a href="' . esc_url( home_url('/') ) . '" title="' . esc_attr( get_bloginfo('name') ) . '">';
		
		echo '<h1>'.get_bloginfo('name').'</h1>';
		
		echo '</a>';
		
		echo '<strong>'.get_bloginfo('description').'</strong>';
	}
}

/**
 *	Used to load the content for posts and pages.
 */
function fbiz_the_content() {

	// Display Thumbnails if thumbnail is set for the post
	if ( has_post_thumbnail() ) {
		
		echo '<a href="'. esc_url( get_permalink() ) .'" title="' . esc_attr( get_the_title() ) . '">';
		
		the_post_thumbnail();
		
		echo '</a>';
	}
	the_content( __( 'Read More', 'fbiz') );
}

/**
 *	Displays the single content.
 */
function fbiz_the_content_single() {

	// Display Thumbnails if thumbnail is set for the post
	if ( has_post_thumbnail() ) {

		the_post_thumbnail();
	}
	the_content( __( 'Read More...', 'fbiz') );
}

/**
 * Displays the slider
 */
function fbiz_display_slider() {

?>
	
	<div class="slider">
		<a href="#" id="unslider-arrow-prev" class="unslider-arrow prev"></a>
		<a href="#" id="unslider-arrow-next" class="unslider-arrow next"></a>
		<ul>
		<?php
			// display slides
			for ( $i = 1; $i <= 3; ++$i ) {

				$defaultSlideContent = __( '<h2>Lorem ipsum dolor</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><a class="btn" title="Read more" href="#">Read more</a>', 'fbiz' );
					
				$defaultSlideImage = get_template_directory_uri().'/img/' . $i .'.jpg';

				$slideContent = get_theme_mod( 'fbiz_slide'.$i.'_content', html_entity_decode( $defaultSlideContent ) );
				$slideImage = get_theme_mod( 'fbiz_slide'.$i.'_image', $defaultSlideImage );

?>					
				<li <?php if ( $slideImage != '' ) : ?>

							style="background-image: url('<?php echo $slideImage; ?>');"

					<?php endif; ?>>
					<div class="slider-content-wrapper">
						<div class="slider-content-container">
							<div class="slide-content">
								<?php echo $slideContent; ?>
							</div>
						</div>
					</div>
				</li>				
<?php
			} ?>
		</ul>
	</div>
<?php 
}

/**
 * Gets additional theme settings description
 */
function fbiz_get_customizer_sectoin_info() {

	$premiumThemeUrl = 'https://tishonator.com/product/tbiz';

	return sprintf( __( 'The fBiz theme is a free version of the professional WordPress theme tBiz. <a href="%s" class="button-primary" target="_blank">Get tBiz Theme</a><br />', 'fbiz' ), $premiumThemeUrl );
}

/**
 * Register theme settings in the customizer
 */
function fbiz_customize_register( $wp_customize ) {

	// Header Image Section
	$wp_customize->add_section( 'header_image', array(
		'title' => __( 'Header Image', 'fbiz' ),
		'description' => fbiz_get_customizer_sectoin_info(),
		'theme_supports' => 'custom-header',
		'priority' => 60,
	) );

	// Colors Section
	$wp_customize->add_section( 'colors', array(
		'title' => __( 'Colors', 'fbiz' ),
		'description' => fbiz_get_customizer_sectoin_info(),
		'priority' => 50,
	) );

	// Background Image Section
	$wp_customize->add_section( 'background_image', array(
			'title' => __( 'Background Image', 'fbiz' ),
			'description' => fbiz_get_customizer_sectoin_info(),
			'priority' => 70,
		) );

	/**
	 * Add Slider Section
	 */
	$wp_customize->add_section(
		'fbiz_slider_section',
		array(
			'title'       => __( 'Slider', 'fbiz' ),
			'capability'  => 'edit_theme_options',
			'description' => fbiz_get_customizer_sectoin_info(),
		)
	);
	
	for ($i = 1; $i <= 3; ++$i) {
	
		$slideContentId = 'fbiz_slide'.$i.'_content';
		$slideImageId = 'fbiz_slide'.$i.'_image';
		$defaultSliderImagePath = get_template_directory_uri().'/img/'.$i.'.jpg';
	
		// Add Slide Content
		$wp_customize->add_setting(
			$slideContentId,
			array(
				'default'           => __( '<h2>Lorem ipsum dolor</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><a class="btn" title="Read more" href="#">Read more</a>', 'fbiz' ),
				'sanitize_callback' => 'force_balance_tags',
			)
		);
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, $slideContentId,
									array(
										'label'          => sprintf( __( 'Slide #%s Content', 'fbiz' ), $i ),
										'section'        => 'fbiz_slider_section',
										'settings'       => $slideContentId,
										'type'           => 'textarea',
										)
									)
		);
		
		// Add Slide Background Image
		$wp_customize->add_setting( $slideImageId,
			array(
				'default' => $defaultSliderImagePath,
				'sanitize_callback' => 'esc_url_raw'
			)
		);

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $slideImageId,
				array(
					'label'   	 => sprintf( __( 'Slide #%s Image', 'fbiz' ), $i ),
					'section' 	 => 'fbiz_slider_section',
					'settings'   => $slideImageId,
				) 
			)
		);
	}

	/**
	 * Add Footer Section
	 */
	$wp_customize->add_section(
		'fbiz_footer_section',
		array(
			'title'       => __( 'Footer', 'fbiz' ),
			'capability'  => 'edit_theme_options',
			'description' => fbiz_get_customizer_sectoin_info(),
		)
	);
	
	// Add footer copyright text
	$wp_customize->add_setting(
		'fbiz_footer_copyright',
		array(
		    'default'           => '',
		    'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fbiz_footer_copyright',
        array(
            'label'          => __( 'Copyright Text', 'fbiz' ),
            'section'        => 'fbiz_footer_section',
            'settings'       => 'fbiz_footer_copyright',
            'type'           => 'text',
            )
        )
	);
}
add_action('customize_register', 'fbiz_customize_register');

?>
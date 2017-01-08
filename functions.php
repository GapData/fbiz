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
 * @subpackage fBiz
 * @author tishonator
 * @since fBiz 1.0.0
 *
 */

require_once( trailingslashit( get_template_directory() ) . 'customize-pro/class-customize.php' );

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
		'primary'   => __( 'Primary Menu', 'fbiz' ),
	) );

	// Add wp_enqueue_scripts actions
	add_action( 'wp_enqueue_scripts', 'fbiz_load_scripts' );

	add_action( 'widgets_init', 'fbiz_widgets_init' );

	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 0, true );

	global $content_width;
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
                       'random-default'         => '',
                       'flex-height'            => true,
                       'flex-width'             => true,
                       'uploads'                => true,
                       'width'                  => 900,
                       'height'                 => 100,
                       'default-text-color'        => '#ffffff',
                       'wp-head-callback'       => 'fbiz_header_style',
                    ) );

    // add custom logo
    add_theme_support( 'custom-logo', array (
                       'width'                  => 145,
                       'height'                 => 36,
                       'flex-height'            => true,
                       'flex-width'             => true,
                    ) );
					
	add_theme_support( "title-tag" );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form', 'comment-list',
	) );

	

	// add the visual editor to resemble the theme style
	add_editor_style( array( 'css/editor-style.css', get_template_directory_uri() . '/css/font-awesome.min.css' ) );
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
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array( ) );
	wp_enqueue_style( 'fbiz-style', get_stylesheet_uri(), array() );
	
	wp_enqueue_style( 'fbiz-fonts', fbiz_fonts_url(), array(), null );
	
	// Load thread comments reply script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
	
	// Load Utilities JS Script
	wp_enqueue_script( 'fbiz-utilities', get_template_directory_uri() . '/js/utilities.js', array( 'jquery' ) );
	
	// Load script for the slider
	wp_enqueue_script( 'unslider', get_template_directory_uri() . '/js/unslider.js', array( 'jquery' ) );
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

	/**
	 * Add Footer Columns Widget areas
	 */
	register_sidebar( array (
							'name'			 =>  __( 'Footer Column #1', 'fbiz' ),
							'id' 			 =>  'footer-column-1-widget-area',
							'description'	 =>  __( 'The Footer Column #1 widget area', 'fbiz' ),
							'before_widget'  =>  '',
							'after_widget'	 =>  '',
							'before_title'	 =>  '<h2 class="footer-title">',
							'after_title'	 =>  '</h2><div class="footer-after-title"></div>',
						) );
						
	register_sidebar( array (
							'name'			 =>  __( 'Footer Column #2', 'fbiz' ),
							'id' 			 =>  'footer-column-2-widget-area',
							'description'	 =>  __( 'The Footer Column #2 widget area', 'fbiz' ),
							'before_widget'  =>  '',
							'after_widget'	 =>  '',
							'before_title'	 =>  '<h2 class="footer-title">',
							'after_title'	 =>  '</h2><div class="footer-after-title"></div>',
						) );
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
 * Display website's logo image
 */
function fbiz_show_website_logo_image_and_title() {

	if ( has_custom_logo() ) {

        the_custom_logo();
    }

    $header_text_color = get_header_textcolor();

    if ( 'blank' !== $header_text_color ) {
    
        echo '<div id="site-identity">';
        echo '<a href="' . esc_url( home_url('/') ) . '" title="' . esc_attr( get_bloginfo('name') ) . '">';
        echo '<h1>'.get_bloginfo('name').'</h1>';
        echo '</a>';
        echo '<strong>'.get_bloginfo('description').'</strong>';
        echo '</div>';
    }
}

/**
 *	Used to load the content for posts and pages.
 */
function fbiz_the_content() {

	// Display Thumbnails if thumbnail is set for the post
	if ( has_post_thumbnail() ) {
?>

		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
			<?php the_post_thumbnail(); ?>
		</a>
								
<?php
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
 * Register theme settings in the customizer
 */
function fbiz_customize_register( $wp_customize ) {

	/**
	 * Add Slider Section
	 */
	$wp_customize->add_section(
		'fbiz_slider_section',
		array(
			'title'       => __( 'Slider', 'fbiz' ),
			'capability'  => 'edit_theme_options',
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

function fbiz_header_style() {

    $header_text_color = get_header_textcolor();

    if ( ! has_header_image()
        && ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color
             || 'blank' === $header_text_color ) ) {

        return;
    }

    $headerImage = get_header_image();
?>
    <style type="text/css">
        <?php if ( has_header_image() ) : ?>

                #header-main-fixed {background-image: url("<?php echo esc_url( $headerImage ); ?>");}

        <?php endif; ?>

        <?php if ( get_theme_support( 'custom-header', 'default-text-color' ) !== $header_text_color
                    && 'blank' !== $header_text_color ) : ?>

                #header-main-fixed {color: #<?php echo esc_attr( $header_text_color ); ?>;}

        <?php endif; ?>
    </style>
<?php

}

?>
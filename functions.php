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

require get_template_directory() . '/inc/admin-options.php';

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

function fbiz_post_classes( $classes ) {
	if ( ! post_password_required() && ! is_attachment() && has_post_thumbnail() ) {
		$classes[] = 'has-post-thumbnail';
	}

	return $classes;
}
add_filter( 'post_class', 'fbiz_post_classes' );

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
	if ( is_singular() ) {
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
	
	$options = fbiz_get_options();
	if ( array_key_exists( 'footer_copyrighttext', $options ) && $options[ 'footer_copyrighttext' ] != '' ) {

		echo esc_html( $options[ 'footer_copyrighttext' ] ) . ' | ';
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

	$options = fbiz_get_options();

	if ( get_header_image() != '' ) {
	
		// Check if the user selected a header Image in the Customizer or the Header Menu
		$logoImgPath = get_header_image();
		$siteTitle = get_bloginfo( 'name' );
		$imageWidth = get_custom_header()->width;
		$imageHeight = get_custom_header()->height;
		
		echo '<a href="'.home_url('/').'" title="'.get_bloginfo('name').'">';
		
		echo "<img src='$logoImgPath' alt='$siteTitle' title='$siteTitle' width='$imageWidth' height='$imageHeight' alt='' />";
		
		echo '</a>';

	} else if ( array_key_exists( 'header_logo', $options ) && $options[ 'header_logo' ] != '' ) {
		 
		echo '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo('name') ) . '">';
		
		$logoImgPath = $options[ 'header_logo' ];
		$siteTitle = get_bloginfo( 'name' );
		
		echo "<img src='" . esc_attr( $logoImgPath ) . "' alt='" . esc_attr( $siteTitle ) . "' title='" . esc_attr( $siteTitle ) . "' />";
	
		echo '</a>';

	} else {
	
		echo '<a href="' . esc_url( home_url('/') ) . '" title="' . esc_attr( get_bloginfo('name') ) . '">';
		
		echo '<h1>'.get_bloginfo('name').'</h1>';
		
		echo '</a>';
		
		echo '<strong>'.get_bloginfo('description').'</strong>';
	}
}

/**
 *	Displays the page navigation
 */
function fbiz_show_pagenavi( $p = 2 ) { // pages will be show before and after current page

	if ( is_singular() ) {
		return; // do NOT show in single page
	}
  
	global $wp_query, $paged;
	$max_page = $wp_query->max_num_pages;
	
	if ( $max_page == 1 ) {
		return; // don't show when only one page
	}
  
	if ( empty( $paged ) ) {
		$paged = 1;
	}
  
	// pages
	if ( $paged > $p + 1 ) {
		fbiz_p_link( 1, __('First', 'fbiz') );
	}
  
	if ( $paged > $p + 2 ) {
		echo '... ';
	}
  
	for ( $i = $paged - $p; $i <= $paged + $p; ++$i ) { 
		// Middle pages
		if ( $i > 0 && $i <= $max_page ) {
			$i == $paged ? print "<span class='page-numbers current'>{$i}</span> " : fbiz_p_link($i);
		}
	}
  
	if ( $paged < $max_page - $p - 1 ) {
		echo '... ';
	}
  
	if ( $paged < $max_page - $p ) {
		fbiz_p_link( $max_page, __('Last', 'fbiz') );
	}
}

function fbiz_p_link( $i, $title = '' ) {

	if ( $title == '' ) {
		$title = sprintf( __('Page %s', 'fbiz'), $i );
	}
	
	echo "<a class='page-numbers' href='", esc_url( get_pagenum_link( $i ) ), "' title='", esc_attr($title), "'>{$i}</a>";
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
	/**
	 *	Get options
	 */
	$options = fbiz_get_options();
	if ($options === false) {
		return;
	}
	
	/**
	 * Check if we need to display slider: there should be
	 * at least one slider with background image and content
	 */
	$skipSliderDisplay = true;
	for ( $i = 1; $i <= 3; ++$i ) {
	 
		$sliderContentKey = 'slider_slide'.$i.'_content';
		$slideImageKey = 'slider_slide'.$i.'_image';
			
		if ( array_key_exists( $sliderContentKey, $options ) && $options[ $sliderContentKey ] != ''
			&& array_key_exists( $slideImageKey, $options ) && $options[ $slideImageKey ] != '' ) {
				
			$skipSliderDisplay = false;
			break;
		}
	}
	 
	if ($skipSliderDisplay) {
		return;
	}
?>
	
	<div class="slider">
		<a href="#" id="unslider-arrow-prev" class="unslider-arrow prev"></a>
		<a href="#" id="unslider-arrow-next" class="unslider-arrow next"></a>
		<ul>
		<?php
			// display slides
			for ( $i = 1; $i <= 3; ++$i ) {
			
				$sliderContentKey = 'slider_slide'.$i.'_content';
				$slideImageKey = 'slider_slide'.$i.'_image';
				
				if ( array_key_exists( $sliderContentKey, $options ) && $options[ $sliderContentKey ] != ''
					&& array_key_exists( $slideImageKey, $options ) && $options[ $slideImageKey ] != '' ) {

						$slideContent = $options[ $sliderContentKey ];
						$slideImage = $options[ $slideImageKey ];
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
					}
			} ?>
		</ul>
	</div>
<?php 
}

?>
<?php
/**
 * @package Layers
 */

/**
* Add define Layers constants to be used around Layers themes, plugins etc.
*/

/**
 * The current version of the theme. Use a random number for SCRIPT_DEBUG mode
 */
if ( defined( 'SCRIPT_DEBUG' ) && TRUE == SCRIPT_DEBUG ) {
	define( 'LAYERS_VERSION', rand( 0 , 100 ) );
} else {
	define( 'LAYERS_VERSION', 'beta-0.1' );
}

define( 'LAYERS_TEMPLATE_URI' , get_template_directory_uri() );
define( 'LAYERS_TEMPLATE_DIR' , get_template_directory() );
define( 'LAYERS_THEME_TITLE' , 'Layers' );
define( 'LAYERS_THEME_SLUG' , 'layers' );
define( 'LAYERS_BUILDER_TEMPLATE' , 'builder.php' );
define( 'OBOX_URL' , 'http://oboxthemes.com');

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 660; /* pixels */


/**
 * Adjust the content width when the full width page template is being used
 */
function layers_set_content_width() {
	global $content_width;

	if ( is_page_template( 'full-width.php' ) ) {
		$content_width = 1080;
	} elseif( is_singular() ) {
		$content_width = 660;
	}
}
add_action( 'template_redirect', 'layers_set_content_width' );

/*
 * Third Party Scripts
 */
require_once get_template_directory() . '/core/third-party/site-logo.php';

/*
 * Load Widgets
 */
require_once get_template_directory() . '/core/widgets/init.php';

/*
 * Load Customizer Support
 */
require_once get_template_directory() . '/core/customizer/init.php';

/*
 * Load Custom Post Meta
 */
require_once get_template_directory() . '/core/meta/init.php';

/*
 * Load Widgets
 */
require_once get_template_directory() . '/core/widgets/init.php';

/*
 * Load Front-end helpers
 */
require_once get_template_directory() . '/core/helpers/post.php';
require_once get_template_directory() . '/core/helpers/template.php';
require_once get_template_directory() . '/core/helpers/extensions.php';


/*
 * Load Admin-specific files
 */
if( is_admin() ){
	// Include form item class
	require_once get_template_directory() . '/core/helpers/forms.php';

	// Include design bar class
	require_once get_template_directory() . '/core/helpers/design-bar.php';

	// Include pointers class
	require_once get_template_directory() . '/core/helpers/pointers.php';

	// Include API class
	require_once get_template_directory() . '/core/helpers/api.php';

	// Include widget export/import class
	require_once get_template_directory() . '/core/helpers/migrator.php';

	//Load Options Panel
	require_once get_template_directory() . '/core/options-panel/init.php';

}

if( ! function_exists( 'layers_setup' ) ) {
	function layers_setup(){
		global $pagenow;

		/**
		 * Add support for HTML5
		 */
		add_theme_support('html5');
		/**
		 * Add support for widgets inside the customizer
		 */
		add_theme_support('widget-customizer');

		/**
		 * Add support for WooCommerce
		 */
		add_theme_support( 'woocommerce' );

		/**
		 * Add support for featured images
		 */
		add_theme_support( 'post-thumbnails' );

		// Set Large Image Sizes
		add_image_size( 'square-large', 960, 960, true );
		add_image_size( 'portrait-large', 720, 960, true );
		add_image_size( 'landscape-large', 960, 720, true );

		// Set Medium Image Sizes
		add_image_size( 'square-medium', 480, 480, true );
		add_image_size( 'portrait-medium', 340, 480, true );
		add_image_size( 'landscape-medium', 480, 340, true );

		/**
		 * Add theme support
		 */

		// Custom Site Logo
		add_theme_support( 'site-logo', array(
			'header-text' => array(
				'sitetitle',
				'tagline',
			),
			'size' => 'medium',
		) );

		// Automatic Feed Links
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Register nav menus
		 */
		register_nav_menus( array(
			LAYERS_THEME_SLUG . '-secondary-left' => __( 'Top Left Menu', LAYERS_THEME_SLUG ),
			LAYERS_THEME_SLUG . '-secondary-right' => __( 'Top Right Menu', LAYERS_THEME_SLUG ),
			LAYERS_THEME_SLUG . '-primary' => __( 'Header Menu', LAYERS_THEME_SLUG ),
			LAYERS_THEME_SLUG . '-primary-right' => __( 'Right Header Menu', LAYERS_THEME_SLUG ),
			LAYERS_THEME_SLUG . '-footer' => __( 'Footer Menu', LAYERS_THEME_SLUG ),

		) );

		/**
		 * Add support for Jetpack Portfolio
		 */
		add_theme_support( 'jetpack-portfolio' );

		/**
		* Welcome Redirect
		*/
		if( isset($_GET["activated"]) && "themes.php" == $pagenow) {
			update_option( 'layers_welcome' , 1);

			wp_redirect(admin_url('admin.php?page=' . LAYERS_THEME_SLUG . '-welcome'));
		}
	} // function layers_setup
	add_action( 'after_setup_theme' , 'layers_setup', 10 );
} // if !function layers_setup

/**
*  Enqueue front end styles and scripts
*/
if( ! function_exists( 'layers_register_standard_sidebars' ) ) {
	function layers_register_standard_sidebars(){
		/**
		 * Register Standard Sidebars
		 */
		register_sidebar( array(
			'id'		=> LAYERS_THEME_SLUG . '-off-canvas-sidebar',
			'name'		=> __( 'Pop Out Sidebar' , LAYERS_THEME_SLUG ),
			'description'	=> __( '' , LAYERS_THEME_SLUG ),
			'before_widget'	=> '<aside id="%1$s" class="content widget %2$s">',
			'after_widget'	=> '</aside>',
			'before_title'	=> '<h5 class="section-nav-title">',
			'after_title'	=> '</h5>',
		) );

		register_sidebar( array(
			'id'		=> LAYERS_THEME_SLUG . '-left-sidebar',
			'name'		=> __( 'Left Sidebar' , LAYERS_THEME_SLUG ),
			'before_widget'	=> '<aside id="%1$s" class="content well push-bottom widget %2$s">',
			'after_widget'	=> '</aside>',
			'before_title'	=> '<h5 class="section-nav-title">',
			'after_title'	=> '</h5>',
		) );

		register_sidebar( array(
			'id'		=> LAYERS_THEME_SLUG . '-right-sidebar',
			'name'		=> __( 'Right Sidebar' , LAYERS_THEME_SLUG ),
			'before_widget'	=> '<aside id="%1$s" class="content well push-bottom widget %2$s">',
			'after_widget'	=> '</aside>',
			'before_title'	=> '<h5 class="section-nav-title">',
			'after_title'	=> '</h5>',
		) );

		/**
		 * Register Footer Sidebars
		 */
		for( $footer = 1; $footer < 5; $footer++ ) {
			register_sidebar( array(
				'id'		=> LAYERS_THEME_SLUG . '-footer-' . $footer,
				'name'		=> __( 'Footer ' . $footer , LAYERS_THEME_SLUG ),
				'before_widget'	=> '<section id="%1$s" class="widget %2$s">',
				'after_widget'	=> '</section>',
				'before_title'	=> '<h5 class="section-nav-title">',
				'after_title'	=> '</h5>',
			) );
		} // for footers
	}
	add_action( 'widgets_init' , 'layers_register_standard_sidebars' , 50 );
}
/**
*  Enqueue front end styles and scripts
*/
if( ! function_exists( 'layers_scripts' ) ) {
	function layers_scripts(){

		/**
		* Front end Scripts
		*/

		wp_enqueue_script(
			LAYERS_THEME_SLUG . '-sticky-kit-js' ,
			get_template_directory_uri() . '/assets/js/sticky-kit.js',
			array(
				'jquery',
			)
		); // Sticky-Kit

		wp_enqueue_script(
			LAYERS_THEME_SLUG . '-waypoints-js' ,
			get_template_directory_uri() . '/assets/js/waypoint.js',
			array(
				'jquery',
			)
		); // Waypoints
		
		wp_enqueue_script( 'jquery-masonry' ); // Wordpress Masonry

		wp_enqueue_script(
			LAYERS_THEME_SLUG . '-layers-masonry-js' ,
			get_template_directory_uri() . '/assets/js/layers.masonry.js',
			array(
				'jquery'
			)
		); // Layers Masonry Function
		
		wp_enqueue_script(
			LAYERS_THEME_SLUG . '-imagesloaded-js' ,
			get_template_directory_uri() . '/assets/js/imagesloaded.js',
			array(
				'jquery',
			)
		); // Waypoints

		wp_enqueue_script(
			LAYERS_THEME_SLUG . '-framework-js' ,
			get_template_directory_uri() . '/assets/js/layers.framework.js',
			array(
				'jquery',
			),
			LAYERS_VERSION,
			true
		); // Framework


		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		} // Comment reply script

		/**
		* Front end Styles
		*/

		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-framework' ,
			get_template_directory_uri() . '/assets/css/framework.css',
			array() ,
			LAYERS_VERSION
		);

		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-invert' ,
			get_template_directory_uri() . '/assets/css/invert.css',
			array() ,
			LAYERS_VERSION
		);

		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-colors',
			get_template_directory_uri() . '/assets/css/colors.css',
			array(),
			LAYERS_VERSION
		); // Colors

		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-typography',
			get_template_directory_uri() . '/assets/css/typography.css',
			array(),
			LAYERS_VERSION
		); // Typography

		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-components',
			get_template_directory_uri() . '/assets/css/components.css',
			array(),
			LAYERS_VERSION
		); // Compontents

		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-responsive',
			get_template_directory_uri() . '/assets/css/responsive.css',
			array(),
			LAYERS_VERSION
		); // Responsive

		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-icon-fonts',
			get_template_directory_uri() . '/assets/css/layers-icons.css',
			array(),
			LAYERS_VERSION
		); // Icon Font

		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-admin',
			get_template_directory_uri() . '/core/assets/admin.css',
			array('admin-bar'),
			LAYERS_VERSION
		); // Admin CSS - depending on admin-bar loaded

		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-style' ,
			get_stylesheet_uri(),
			array() ,
			LAYERS_VERSION
		);

	}
}
add_action( 'wp_enqueue_scripts' , 'layers_scripts' );


/**
*  Enqueue admin end styles and scripts
*/
if( ! function_exists( 'layers_admin_scripts' ) ) {
	function layers_admin_scripts(){
		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-admin',
			get_template_directory_uri() . '/core/assets/admin.css',
			array(),
			LAYERS_VERSION
		); // Admin CSS

		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-admin-editor',
			get_template_directory_uri() . '/core/assets/editor.min.css',
			array(),
			LAYERS_VERSION
		); // Admin CSS

		wp_enqueue_script(
			LAYERS_THEME_SLUG . '-admin-editor' ,
			get_template_directory_uri() . '/core/assets/editor.min.js' ,
			array( 'jquery' ),
			LAYERS_VERSION,
			true
		);

        // Migrator
        wp_enqueue_script(
            LAYERS_THEME_SLUG . '-admin-migrator' ,
            get_template_directory_uri() . '/core/assets/migrator.js' ,
            array(),
            LAYERS_VERSION,
            true
        );
        wp_localize_script( LAYERS_THEME_SLUG . '-admin-migrator', 'migratori8n', array(
        	'loading_message' => __( 'Be patient while we import the widget data and images.' , LAYERS_THEME_SLUG )
		) );

		wp_enqueue_script(
			LAYERS_THEME_SLUG . '-admin' ,
			get_template_directory_uri() . '/core/assets/admin.js',
			array(
				'jquery',
				'jquery-ui-sortable',
				'wp-color-picker'
			),
			LAYERS_VERSION,
			true
		); // Admin JS


	}
}

add_action( 'customize_controls_print_footer_scripts' , 'layers_admin_scripts' );
add_action( 'admin_enqueue_scripts' , 'layers_admin_scripts' );

/**
*  Make sure that all excerpts have class="excerpt"
*/
if( !function_exists( 'layers_excerpt_class' ) ) {
	function layers_excerpt_class( $excerpt ) {
	    return str_replace('<p', '<p class="excerpt"', $excerpt);
	}
	add_filter( "the_excerpt", "layers_excerpt_class" );
	add_filter( "get_the_excerpt", "layers_excerpt_class" );
} // layers_excerpt_class

/**
*  Adjust the site title for static front pages
*/
if( !function_exists( 'layers_site_title' ) ) {
	function layers_site_title( $title ) {
		global $paged, $page;

		if( !isset( $sep ) ) $sep = '|';

		if ( is_feed() )
			return $title;

		// Add the site name.
		$title .= get_bloginfo( 'name' );

		// Add the site description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );

		if ( $site_description && ( is_home() || is_front_page() ) )
			$title = "$title $sep $site_description";

		// Add a page number if necessary.
		if ( $paged >= 2 || $page >= 2 )
			$title = "$title $sep " . sprintf( __( 'Page %s', LAYERS_THEME_SLUG ), max( $paged, $page ) );

		return $title;
	}
	add_filter( "wp_title", "layers_site_title" );
} // layers_site_title

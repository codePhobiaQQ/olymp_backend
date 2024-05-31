<?php
/**
 * olymp functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package olymp
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function olymp_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on olymp, use a find and replace
		* to change 'olymp' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'olymp', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'olymp' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'olymp_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'olymp_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function olymp_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'olymp_content_width', 640 );
}
add_action( 'after_setup_theme', 'olymp_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function olymp_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'olymp' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'olymp' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'olymp_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function olymp_scripts() {
	wp_enqueue_style( 'olymp-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'olymp-style', 'rtl', 'replace' );

	wp_enqueue_script( 'olymp-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'olymp_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/** -----------------------------
 * -------- USER SETTINGS -------
 * ------------------------------
*/

add_filter( 'manage_users_columns', 'true_user_is_approved_column' );

function true_user_is_approved_column( $my_columns ) {
    $my_columns[ 'is_email_approved' ] = 'E-mail Подтвержден';
    return $my_columns;
}

add_filter( 'manage_users_custom_column', 'true_user_is_approved_column_content', 25, 3 );

function true_user_is_approved_column_content( $row_output, $column_id, $user ) {
    if( 'is_email_approved' == $column_id ) {
        // возвращаем, а не выводим!
        return get_the_author_meta( 'is_email_approved', $user );
    }
    return $row_output;
}

/** -----------------------------------
 * ----- POST TYPES CUSTOMIZATION -----
 * ------------------------------------
*/
require get_template_directory() . '/custom/post-types/olymp.php';
add_action( 'init', 'register_olymp_post_type' );
add_action( 'save_post_olymp', 'save_olymp_meta' );

require get_template_directory() . '/custom/post-types/organizing-committees.php';
add_action( 'init', 'register_organizing_committees_post_type' );
// add_action( 'save_post', 'save_organizing_committee_meta' );

require get_template_directory() . '/custom/post-types/final-stage-application.php';
add_action( 'init', 'register_final_stage_application_post_type' );
add_action('add_meta_boxes', 'add_final_stage_application_metaboxes');
add_action('save_post', 'save_final_stage_application_meta');

// add_action( 'save_post', 'save_organizing_committee_meta' );

/** -----------------------------
 * ----- MENU CUSTOMIZATION -----
 * ------------------------------
*/
require get_template_directory() . '/custom/menu-customization/qualifying-stage.php';
add_action('admin_menu', 'add_qualifying_stage_menu_item');
add_action('admin_init', 'qualifying_stage_settings_init');

require get_template_directory() . '/custom/menu-customization/final-stage.php';
add_action('admin_menu', 'add_final_stage_menu_item');
add_action('admin_init', 'final_stage_settings_init');

/** -----------------------------
 * ----- CUSTOMIZATION TOKEN ----
 * ------------------------------
 */
require get_template_directory() . '/custom/auth/customise-token.php';
add_filter( 'jwt_auth_token_before_sign', 'customize_token', 10, 2);
add_filter( 'jwt_auth_token_before_dispatch', 'customize_token_response', 10, 2 );

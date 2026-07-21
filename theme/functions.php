<?php
/**
 * dlnorrisbooks functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package dlnorrisbooks
 */

if ( ! defined( 'DLNORRISBOOKS_VERSION' ) ) {
	/*
	 * Set the theme’s version number.
	 *
	 * This is used primarily for cache busting. If you use `npm run bundle`
	 * to create your production build, the value below will be replaced in the
	 * generated zip file with a timestamp, converted to base 36.
	 */
	define( 'DLNORRISBOOKS_VERSION', '0.1.0' );
}

if ( ! defined( 'DLNORRISBOOKS_TYPOGRAPHY_CLASSES' ) ) {
	/*
	 * Set Tailwind Typography classes for the front end, block editor and
	 * classic editor using the constant below.
	 *
	 * For the front end, these classes are added by the `dlnorrisbooks_content_class`
	 * function. You will see that function used everywhere an `entry-content`
	 * or `page-content` class has been added to a wrapper element.
	 *
	 * For the block editor, these classes are converted to a JavaScript array
	 * and then used by the `./javascript/block-editor.js` file, which adds
	 * them to the appropriate elements in the block editor (and adds them
	 * again when they’re removed.)
	 *
	 * For the classic editor (and anything using TinyMCE, like Advanced Custom
	 * Fields), these classes are added to TinyMCE’s body class when it
	 * initializes.
	 */
	define(
		'DLNORRISBOOKS_TYPOGRAPHY_CLASSES',
		'prose prose-dlnorrisbooks max-w-none prose-a:text-accent'
	);
}

if ( ! function_exists( 'dlnorrisbooks_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function dlnorrisbooks_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on dlnorrisbooks, use a find and replace
		 * to change 'dlnorrisbooks' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'dlnorrisbooks', get_template_directory() . '/languages' );

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

		add_theme_support(
			'custom-logo',
			array(
				'height'      => 48,
				'width'       => 240,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'menu-1' => __( 'Primary', 'dlnorrisbooks' ),
				'menu-2' => __( 'Footer Menu', 'dlnorrisbooks' ),
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

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style-editor.css' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		/*
		 * WooCommerce. Declaring support hands the store WordPress's own
		 * header/footer via this theme and unlocks the product gallery
		 * features; the store is then themed through hooks + CSS in
		 * `inc/woocommerce.php` rather than template overrides.
		 */
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		// Remove support for block templates.
		remove_theme_support( 'block-templates' );
	}
endif;
add_action( 'after_setup_theme', 'dlnorrisbooks_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function dlnorrisbooks_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Footer', 'dlnorrisbooks' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in your footer.', 'dlnorrisbooks' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'dlnorrisbooks_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function dlnorrisbooks_scripts() {
	wp_enqueue_style( 'dlnorrisbooks-style', get_stylesheet_uri(), array(), DLNORRISBOOKS_VERSION );
	wp_enqueue_script( 'dlnorrisbooks-script', get_template_directory_uri() . '/js/script.min.js', array(), DLNORRISBOOKS_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'dlnorrisbooks_scripts' );

/**
 * Enqueue the block editor script.
 */
function dlnorrisbooks_enqueue_block_editor_script() {
	$current_screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;

	if (
		$current_screen &&
		$current_screen->is_block_editor() &&
		'widgets' !== $current_screen->id
	) {
		wp_enqueue_script(
			'dlnorrisbooks-editor',
			get_template_directory_uri() . '/js/block-editor.min.js',
			array(
				'wp-blocks',
				'wp-edit-post',
				'wp-hooks',
			),
			DLNORRISBOOKS_VERSION,
			true
		);
		wp_add_inline_script( 'dlnorrisbooks-editor', "tailwindTypographyClasses = '" . esc_attr( DLNORRISBOOKS_TYPOGRAPHY_CLASSES ) . "'.split(' ');", 'before' );
		wp_add_inline_script(
			'dlnorrisbooks-editor',
			'window.dlnorrisbooksTheme = { uri: "' . esc_url( get_template_directory_uri() ) . '", postType: "' . esc_js( $current_screen->post_type ) . '" };',
			'before'
		);
	}
}
add_action( 'enqueue_block_assets', 'dlnorrisbooks_enqueue_block_editor_script' );

/**
 * Add the Tailwind Typography classes to TinyMCE.
 *
 * @param array $settings TinyMCE settings.
 * @return array
 */
function dlnorrisbooks_tinymce_add_class( $settings ) {
	$settings['body_class'] = DLNORRISBOOKS_TYPOGRAPHY_CLASSES;
	return $settings;
}
add_filter( 'tiny_mce_before_init', 'dlnorrisbooks_tinymce_add_class' );

/**
 * Limit the block editor to heading levels supported by Tailwind Typography.
 *
 * @param array  $args Array of arguments for registering a block type.
 * @param string $block_type Block type name including namespace.
 * @return array
 */
function dlnorrisbooks_modify_heading_levels( $args, $block_type ) {
	if ( 'core/heading' !== $block_type ) {
		return $args;
	}

	// Remove <h1>, <h5> and <h6>.
	$args['attributes']['levelOptions']['default'] = array( 2, 3, 4 );

	return $args;
}
add_filter( 'register_block_type_args', 'dlnorrisbooks_modify_heading_levels', 10, 2 );

/**
 * Register a custom block category for the theme's blocks.
 *
 * @param array $categories Existing block categories.
 * @return array
 */
function dlnorrisbooks_block_categories( $categories ) {
	return array_merge(
		array(
			array(
				'slug'  => 'dlnorrisbooks',
				'title' => __( 'D. L. Norris', 'dlnorrisbooks' ),
				'icon'  => null,
			),
		),
		$categories
	);
}
add_filter( 'block_categories_all', 'dlnorrisbooks_block_categories' );

/**
 * Register all built theme blocks.
 *
 * Each block lives in its own folder under `/blocks`, built from `/src/blocks`
 * by `@wordpress/scripts`. Any folder containing a `block.json` is registered.
 */
function dlnorrisbooks_register_blocks() {
	$blocks_dir = get_template_directory() . '/blocks';

	if ( ! is_dir( $blocks_dir ) ) {
		return;
	}

	$block_folders = glob( $blocks_dir . '/*', GLOB_ONLYDIR );

	if ( empty( $block_folders ) ) {
		return;
	}

	foreach ( $block_folders as $block_folder ) {
		if ( file_exists( $block_folder . '/block.json' ) ) {
			register_block_type( $block_folder );
		}
	}
}
add_action( 'init', 'dlnorrisbooks_register_blocks' );

/**
 * Detect a request for page 2+ of a static page whose Recent Stories block
 * drives its own pagination (e.g. `/blog/2/`).
 *
 * On a static page WordPress reads the trailing number as `<!--nextpage-->`
 * pagination. Because the page itself isn't split it would otherwise 404 the
 * request and canonical-redirect back to page 1 — but here the block runs its
 * own query off that page number, so those two behaviours are suppressed for
 * matching pages only.
 *
 * @param WP_Query|null $query Optional query to inspect. Defaults to the main query.
 * @return bool
 */
function dlnorrisbooks_is_paginated_stories_request( $query = null ) {
	if ( ! $query instanceof WP_Query ) {
		$query = isset( $GLOBALS['wp_query'] ) ? $GLOBALS['wp_query'] : null;
	}

	$dlnorrisbooks_page = (int) $query->get( 'page' );

	if ( ! $query instanceof WP_Query || $dlnorrisbooks_page < 2 ) {
		return false;
	}

	$dlnorrisbooks_post = $query->get_queried_object();

	if (
		! $dlnorrisbooks_post instanceof WP_Post ||
		! has_block( 'dlnorrisbooks/recent-stories', $dlnorrisbooks_post )
	) {
		return false;
	}

	foreach ( parse_blocks( $dlnorrisbooks_post->post_content ) as $dlnorrisbooks_block ) {
		if (
			'dlnorrisbooks/recent-stories' !== $dlnorrisbooks_block['blockName'] ||
			empty( $dlnorrisbooks_block['attrs']['paginate'] )
		) {
			continue;
		}

		// Only treat the page as valid when it's within range, so an
		// out-of-range number (e.g. /blog/99/) still 404s normally.
		$dlnorrisbooks_per_page = ! empty( $dlnorrisbooks_block['attrs']['count'] )
			? (int) $dlnorrisbooks_block['attrs']['count']
			: 4;
		$dlnorrisbooks_published = (int) wp_count_posts( 'post' )->publish;
		$dlnorrisbooks_max_pages = $dlnorrisbooks_per_page > 0
			? (int) ceil( $dlnorrisbooks_published / $dlnorrisbooks_per_page )
			: 1;

		return $dlnorrisbooks_page <= $dlnorrisbooks_max_pages;
	}

	return false;
}

/**
 * Keep page 2+ of a paginated Recent Stories page from being treated as a 404.
 *
 * @param bool     $preempt Whether to short-circuit default 404 handling.
 * @param WP_Query $query   The query being processed.
 * @return bool
 */
function dlnorrisbooks_prevent_stories_404( $preempt, $query ) {
	if ( dlnorrisbooks_is_paginated_stories_request( $query ) ) {
		return true;
	}

	return $preempt;
}
add_filter( 'pre_handle_404', 'dlnorrisbooks_prevent_stories_404', 10, 2 );

/**
 * Stop WordPress canonical-redirecting `/blog/2/` back to `/blog/`.
 *
 * @param string $redirect_url The intended redirect URL.
 * @return string|false
 */
function dlnorrisbooks_allow_block_pagination( $redirect_url ) {
	if ( dlnorrisbooks_is_paginated_stories_request() ) {
		return false;
	}

	return $redirect_url;
}
add_filter( 'redirect_canonical', 'dlnorrisbooks_allow_block_pagination' );

/**
 * Custom post types.
 */
require get_template_directory() . '/inc/post-types.php';

/**
 * Advanced Custom Fields field groups (no-ops when ACF is inactive).
 */
require get_template_directory() . '/inc/acf-fields.php';

/**
 * WooCommerce integration (no-op when WooCommerce is inactive).
 */
require get_template_directory() . '/inc/woocommerce.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

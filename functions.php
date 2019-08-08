<?php
/**
 * Yukiascores functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Yukiascores
 */

if ( ! function_exists( 'yukiascores_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function yukiascores_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Yukiascores, use a find and replace
		 * to change 'yukiascores' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'yukiascores', get_template_directory() . '/languages' );

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
                add_image_size('yukiascores-full-bleed', 2000, 1200, true);
                add_image_size('yukiascores-index-img', 800, 450, true);

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'header' => esc_html__( 'Header Menu', 'yukiascores' ),
			'social' => esc_html__( 'Social Menu', 'yukiascores' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'yukiascores_custom_background_args', array(
			'default-color' => '000000',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 90,
			'width'       => 90,
			'flex-width'  => true,
			'flex-height' => true,
		) );
                
                /* Editor Styles */
                add_editor_style( array( 'inc/editor-styles.css', yukiascores_fonts_url()));
	}
endif;
add_action( 'after_setup_theme', 'yukiascores_setup' );


/**
 * Register custom fonts.
 */
function yukiascores_fonts_url() {
	$fonts_url = '';

	/*
	 * Translators: If there are characters in your language that are not
	 * supported by Source Sans Pro and PT Serif, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$source_sans_pro = _x( 'on', 'Source Sans Pro font: on or off', 'yukiascores' );
        
        $pt_serif= _x( 'on', 'PT Serif font: on or off', 'yukiascores' );
        
        $font_families = array();
        
        if ( 'off' !== $source_sans_pro ) {
            $font_families[] = 'Source Sans Pro:400,400i,700,900';
        }
        
        if ( 'off' !== $pt_serif ) {
            $font_families[] = 'PT Serif:400,400i,700,700i';
        }

	if (in_array('on', array($source_sans_pro, $pt_serif)) ) {

		$query_args = array(
			'family'  => urlencode( implode( '|', $font_families ) ),
			'subset'  => urlencode( 'latin,latin-ext' ),
			'display' => urlencode( 'fallback' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function yukiascores_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'yukiascores-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'yukiascores_resource_hints', 10, 2 );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function yukiascores_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'yukiascores_content_width', 640 );
}
add_action( 'after_setup_theme', 'yukiascores_content_width', 0 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @origin Twenty Seventeen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function yukiascores_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];
	if ( 900 <= $width ) {
		$sizes = '(min-width: 900px) 700px, 900px';
	}
	if ( is_active_sidebar( 'sidebar-1' ) || is_active_sidebar( 'page-1' ) ) {
		$sizes = '(min-width: 900px) 600px, 900px';
	}
	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'yukiascores_content_image_sizes_attr', 10, 2 );
/**
 * Filter the `sizes` value in the header image markup.
 *
 * @origin Twenty Seventeen 1.0
 *
 * @param string $html   The HTML image tag markup being filtered.
 * @param object $header The custom header object returned by 'get_custom_header()'.
 * @param array  $attr   Array of the attributes for the image tag.
 * @return string The filtered header image HTML.
 */
function yukiascores_header_image_tag( $html, $header, $attr ) {
	if ( isset( $attr['sizes'] ) ) {
		$html = str_replace( $attr['sizes'], '100vw', $html );
	}
	return $html;
}
add_filter( 'get_header_image_tag', 'yukiascores_header_image_tag', 10, 3 );
/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @origin Twenty Seventeen 1.0
 *
 * @param array $attr       Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size       Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function yukiascores_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( !is_singular() ) {
		if ( is_active_sidebar( 'sidebar-1' ) ) {
			$attr['sizes'] = '(max-width: 900px) 90vw, 800px';
		} else {
			$attr['sizes'] = '(max-width: 1000px) 90vw, 1000px';
		}
	} else {
		$attr['sizes'] = '100vw';
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'yukiascores_post_thumbnail_sizes_attr', 10, 3 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function yukiascores_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'yukiascores' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add footer widgets here.', 'yukiascores' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
        
        register_sidebar( array(
		'name'          => esc_html__( 'Footer Widgets', 'yukiascores' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Add footer widgets here.', 'yukiascores' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
        
        register_sidebar( array(
		'name'          => esc_html__( 'Page Widgets', 'yukiascores' ),
		'id'            => 'page-1',
		'description'   => esc_html__( 'Add page widgets here.', 'yukiascores' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'yukiascores_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function yukiascores_scripts() {
        // Enqueue Google Fonts: Source Sans Pro and PT Serif
        wp_enqueue_style('yukiascores-fonts', yukiascores_fonts_url());
    
	wp_enqueue_style( 'yukiascores-style', get_stylesheet_uri() );

	wp_enqueue_script( 'yukiascores-navigation', get_template_directory_uri() . '/js/navigation.js', array('jquery'), '20151215', true );
        wp_localize_script('yukiascores-navigation', 'yukiascoresScreenReaderText', array(
            'expand' => __('Expand child menu', 'yukiascores'),
            'collapse' => __('Collapse child menu', 'yukiascores'),
        ));
        
        wp_enqueue_script( 'yukiascores-functions', get_template_directory_uri() . '/js/functions.js', array('jquery'), '20190723', true );

	wp_enqueue_script( 'yukiascores-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'yukiascores_scripts' );

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
 * Functions for svg images.
 */
require get_template_directory() . '/inc/icon-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Sidebar detect.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}



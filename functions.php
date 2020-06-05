<?php
/**
 * Credence functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Credence
 * @since 1.0.0
 */

/**
 * Table of Contents:
 * Theme Support
 * Required Files
 * Register Styles
 * Register Scripts
 * Register Menus
 * Custom Logo
 * WP Body Open
 * Register Sidebars
 * Enqueue Block Editor Assets
 * Enqueue Classic Editor Styles
 * Block Editor Settings
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function cred_theme_support() {

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Set content-width.
	global $content_width;
	if ( ! isset( $content_width ) ) :
		$content_width = 580;
	endif;

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// Set post thumbnail size.
	set_post_thumbnail_size( 1050, 700 );

	// Add custom image size used in Cover Template.
	add_image_size( 'cred-post-thumb', 1050, 700 );
	add_image_size( 'cred-related-post', 330, 220 );

	// Custom logo.
	$logo_width  = 120;
	$logo_height = 90;

	// If the retina setting is active, double the recommended width and height.
	if ( get_theme_mod( 'retina_logo', false ) ) :
		$logo_width  = floor( $logo_width * 2 );
		$logo_height = floor( $logo_height * 2 );
	endif;

	add_theme_support(
		'custom-logo',
		array(
			'height'      => $logo_height,
			'width'       => $logo_width,
			'flex-height' => true,
			'flex-width'  => true
		)
	);

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

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
			'script',
			'style'
		)
	);

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Credence, use a find and replace
	 * to change 'credence' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'credence', get_template_directory() . '/languages' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * Adds `async` and `defer` support for scripts registered or enqueued
	 * by the theme.
	 */
	$loader = new Cred_Script_Loader();
	add_filter( 'script_loader_tag', array( $loader, 'filter_script_loader_tag' ), 10, 2 );

}

add_action( 'after_setup_theme', 'cred_theme_support' );

/**
 * REQUIRED FILES
 * Include required files.
 */
require get_template_directory() . '/inc/template-tags.php';

// Handle SVG icons.
require get_template_directory() . '/classes/class-cred-svg-icons.php';
require get_template_directory() . '/inc/svg-icons.php';

// Handle Customizer settings.
require get_template_directory() . '/classes/class-cred-customize.php';

// Custom comment walker.
require get_template_directory() . '/classes/class-cred-walker-comment.php';

// Custom page walker.
require get_template_directory() . '/classes/class-cred-walker-page.php';

// Custom script loader class.
require get_template_directory() . '/classes/class-cred-script-loader.php';

// Non-latin language handling.
require get_template_directory() . '/classes/class-cred-non-latin-languages.php';

// Radio Image Selector
require get_template_directory() . '/classes/radio-img-control.php';

// Range Custom Control
require get_template_directory() . '/classes/range-custom-control.php';

// Google font Custom Control
require get_template_directory() . '/classes/google-font-control.php';

// Custome Heading
require get_template_directory() . '/classes/heading-control.php';

// Custom CSS.
require get_template_directory() . '/inc/custom-css.php';

// Alignment Custom CSS.
require get_template_directory() . '/classes/alignment-custom-control.php';

// helper file
require get_template_directory() . '/inc/helper.php';

/**
 * Register and Enqueue Styles.
 */
function cred_register_styles() {

	$theme_version = wp_get_theme()->get( 'Version' );
	$file_prefix = '';
	if ( is_rtl() ) {
		$file_prefix .= '-rtl';
	}

	wp_enqueue_style( 'cred-style', get_template_directory_uri() . '/assets/css/style' . $file_prefix . '.min.css', array(), $theme_version );

	// Add output of Customizer settings as inline style.
	wp_add_inline_style( 'cred-style', cred_get_customizer_css( 'front-end' ) );

	wp_enqueue_style('cred-google-fonts', cred_fonts_url(), array(), null);
}

add_action( 'wp_enqueue_scripts', 'cred_register_styles' );

/**
 * Register and Enqueue Styles for Admin Area.
 */
function cred_admin_enqueue_styles() {
	$theme_version = wp_get_theme()->get( 'Version' );
	wp_enqueue_style( 'credence-admin-style', get_template_directory_uri() . '/assets/css/credence-admin.css', null, $theme_version );
}
add_action( 'admin_enqueue_scripts', 'cred_admin_enqueue_styles' );



/**
 * Register and Enqueue Scripts.
 */
function cred_register_scripts() {

	$theme_version = wp_get_theme()->get( 'Version' );

	if ( ( ! is_admin() ) && is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'cred-js', get_template_directory_uri() . '/assets/js/index.min.js', array( 'jquery' ), $theme_version, true );
	wp_script_add_data( 'cred-js', 'async', true );

}

add_action( 'wp_enqueue_scripts', 'cred_register_scripts' );

/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 */
function cred_skip_link_focus_fix() {
	// The following is minified via `terser --compress --mangle -- assets/js/skip-link-focus-fix.js`.
	?>
	<script>
	/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
	</script>
	<?php
}
add_action( 'wp_print_footer_scripts', 'cred_skip_link_focus_fix' );

/** Enqueue non-latin language styles
 *
 * @since 1.0.0
 *
 * @return void
 */
function cred_non_latin_languages() {
	$custom_css = Cred_Non_Latin_Languages::get_non_latin_css( 'front-end' );

	if ( $custom_css ) :
		wp_add_inline_style( 'cred-style', $custom_css );
	endif;
}

add_action( 'wp_enqueue_scripts', 'cred_non_latin_languages' );

/**
 * Register navigation menus uses wp_nav_menu in five places.
 */
function cred_menus() {

	$locations = array(
		'primary'  => __( 'Primary Menu', 'credence' ),
		'footer'   => __( 'Footer Menu', 'credence' )
	);

	register_nav_menus( $locations );
}

add_action( 'init', 'cred_menus' );

/**
 * Get the information about the logo.
 *
 * @param string $html The HTML output from get_custom_logo (core function).
 *
 * @return string $html
 */
function cred_get_custom_logo( $html ) {

	$logo_id = get_theme_mod( 'custom_logo' );

	if ( ! $logo_id ) :
		return $html;
	endif;

	$logo = wp_get_attachment_image_src( $logo_id, 'full' );

	if ( $logo ) :
		// For clarity.
		$logo_width  = esc_attr( $logo[1] );
		$logo_height = esc_attr( $logo[2] );

		// If the retina logo setting is active, reduce the width/height by half.
		if ( get_theme_mod( 'retina_logo', false ) ) :
			$logo_width  = floor( $logo_width / 2 );
			$logo_height = floor( $logo_height / 2 );

			$search = array(
				'/width=\"\d+\"/iU',
				'/height=\"\d+\"/iU',
			);

			$replace = array(
				"width=\"{$logo_width}\"",
				"height=\"{$logo_height}\"",
			);

			// Add a style attribute with the height, or append the height to the style attribute if the style attribute already exists.
			if ( false === strpos( $html, ' style=' ) ) :
				$search[]  = '/(src=)/';
				$replace[] = "style=\"height: {$logo_height}px;\" src=";
			else :
				$search[]  = '/(style="[^"]*)/';
				$replace[] = "$1 height: {$logo_height}px;";
			endif;

			$html = preg_replace( $search, $replace, $html );

		endif;
	endif;

	return $html;

}

add_filter( 'get_custom_logo', 'cred_get_custom_logo' );

if ( ! function_exists( 'wp_body_open' ) ) :

	/**
	 * Shim for wp_body_open, ensuring backwards compatibility with versions of WordPress older than 5.2.
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;

/**
 * Include a skip to content link at the top of the page so that users can bypass the menu.
 */
function cred_skip_link() {
	echo '<a class="skip-link screen-reader-text" href="#site-content">' . __( 'Skip to the content', 'credence' ) . '</a>';
}

add_action( 'wp_body_open', 'cred_skip_link', 5 );

/**
 * Register widget areas.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function cred_sidebar_registration() {

	// Arguments used in all register_sidebar() calls.
	$shared_args = array(
		'before_title'  => '<h3 class="widget-title subheading heading-size-3">',
		'after_title'   => '</h3>',
		'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
		'after_widget'  => '</div></div>'
	);

	// Main Sidebar
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __( 'Sidebar', 'credence' ),
				'id'          => 'sidebar-1',
				'description' => __( 'Widgets in this area will be displayed in the sidebar.', 'credence' )
			)
		)
	);

	// Footer #1.
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __( 'Footer One', 'credence' ),
				'id'          => 'footer-one',
				'description' => __( 'Widgets in this area will be displayed in the first column in the footer.', 'credence' )
			)
		)
	);

	// Footer #2.
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __( 'Footer Two', 'credence' ),
				'id'          => 'footer-two',
				'description' => __( 'Widgets in this area will be displayed in the second column in the footer.', 'credence' )
			)
		)
	);

	// Footer #3.
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __( 'Footer Three', 'credence' ),
				'id'          => 'footer-three',
				'description' => __( 'Widgets in this area will be displayed in the third column in the footer.', 'credence' )
			)
		)
	);

	// Footer #4.
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __( 'Footer Four', 'credence' ),
				'id'          => 'footer-four',
				'description' => __( 'Widgets in this area will be displayed in the fourth column in the footer.', 'credence' )
			)
		)
	);

}

add_action( 'widgets_init', 'cred_sidebar_registration' );

/**
 * Enqueue supplemental block editor styles.
 */
function cred_block_editor_styles() {

	$css_dependencies = array();

	// Enqueue the editor styles.
	$file_prefix = '';
	if ( is_rtl() ) {
		$file_prefix .= '-rtl';
	}
	wp_enqueue_style( 'cred-block-editor-styles', get_theme_file_uri( '/assets/css/editor-style-block' . $file_prefix . '.min.css' ), $css_dependencies, wp_get_theme()->get( 'Version' ), 'all' );

	// Add inline style from the Customizer.
	wp_add_inline_style( 'cred-block-editor-styles', cred_get_customizer_css( 'block-editor' ) );

	// Add inline style for non-latin fonts.
	wp_add_inline_style( 'cred-block-editor-styles', Cred_Non_Latin_Languages::get_non_latin_css( 'block-editor' ) );

	// Enqueue the editor script.
	wp_enqueue_script( 'cred-block-editor-script', get_theme_file_uri( '/assets/js/editor-script-block.min.js' ), array( 'wp-blocks', 'wp-dom' ), wp_get_theme()->get( 'Version' ), true );
}

add_action( 'enqueue_block_editor_assets', 'cred_block_editor_styles', 1, 1 );

/**
 * Enqueue classic editor styles.
 */
function cred_classic_editor_styles() {

	$classic_editor_styles = array(
		'/assets/css/editor-style-classic.min.css',
	);

	add_editor_style( $classic_editor_styles );

}

add_action( 'init', 'cred_classic_editor_styles' );

/**
 * Output Customizer settings in the classic editor.
 * Adds styles to the head of the TinyMCE iframe. Kudos to @Otto42 for the original solution.
 *
 * @param array $mce_init TinyMCE styles.
 *
 * @return array $mce_init TinyMCE styles.
 */
function cred_add_classic_editor_customizer_styles( $mce_init ) {

	$styles = cred_get_customizer_css( 'classic-editor' );

	if ( ! isset( $mce_init['content_style'] ) ) :
		$mce_init['content_style'] = $styles . ' ';
	else :
		$mce_init['content_style'] .= ' ' . $styles . ' ';
	endif;

	return $mce_init;

}

add_filter( 'tiny_mce_before_init', 'cred_add_classic_editor_customizer_styles' );

/**
 * Output non-latin font styles in the classic editor.
 * Adds styles to the head of the TinyMCE iframe. Kudos to @Otto42 for the original solution.
 *
 * @param array $mce_init TinyMCE styles.
 *
 * @return array $mce_init TinyMCE styles.
 */
function cred_add_classic_editor_non_latin_styles( $mce_init ) {

	$styles = Cred_Non_Latin_Languages::get_non_latin_css( 'classic-editor' );

	// Return if there are no styles to add.
	if ( ! $styles ) :
		return $mce_init;
	endif;

	if ( ! isset( $mce_init['content_style'] ) ) :
		$mce_init['content_style'] = $styles . ' ';
	else :
		$mce_init['content_style'] .= ' ' . $styles . ' ';
	endif;

	return $mce_init;

}

add_filter( 'tiny_mce_before_init', 'cred_add_classic_editor_non_latin_styles' );

/**
 * Overwrite default more tag with styling and screen reader markup.
 *
 * @param string $html The default output HTML for the more tag.
 *
 * @return string $html
 */
function cred_read_more_tag( $html ) {
	return preg_replace( '/<a(.*)>(.*)<\/a>/iU', sprintf( '<div class="read-more-button-wrap"><a$1><span class="faux-button">$2</span> <span class="screen-reader-text">"%1$s"</span></a></div>', get_the_title( get_the_ID() ) ), $html );
}

add_filter( 'the_content_more_link', 'cred_read_more_tag' );

/**
 * Enqueues scripts for customizer controls & settings.
 *
 * @since 1.0.0
 *
 * @return void
 */
function cred_customize_controls_enqueue_scripts() {
	$theme_version = wp_get_theme()->get( 'Version' );

	// Add main customizer js file.
	wp_enqueue_script( 'cred-customize', get_template_directory_uri() . '/assets/js/customize.min.js', array( 'jquery' ), $theme_version, false );

	// Add script for color calculations.
	wp_enqueue_script( 'cred-color-calculations', get_template_directory_uri() . '/assets/js/color-calculations.min.js', array( 'wp-color-picker' ), $theme_version, false );

	// Add script for controls.
	wp_enqueue_script( 'cred-customize-controls', get_template_directory_uri() . '/assets/js/customize-controls.min.js', array( 'cred-color-calculations', 'customize-controls', 'underscore', 'jquery' ), $theme_version, false );
	wp_localize_script( 'cred-customize-controls', 'credBgColors', cred_get_customizer_color_vars() );
}

add_action( 'customize_controls_enqueue_scripts', 'cred_customize_controls_enqueue_scripts' );

/**
 * Enqueue scripts for the customizer preview.
 *
 * @since 1.0.0
 *
 * @return void
 */
function cred_customize_preview_init() {
	$theme_version = wp_get_theme()->get( 'Version' );

	wp_enqueue_script( 'cred-customize-preview', get_theme_file_uri( '/assets/js/customize-preview.min.js' ), array( 'customize-preview', 'customize-selective-refresh', 'jquery' ), $theme_version, true );
	wp_localize_script( 'cred-customize-preview', 'credBgColors', cred_get_customizer_color_vars() );
}

add_action( 'customize_preview_init', 'cred_customize_preview_init' );

/**
 * Get accessible color for an area.
 *
 * @since 1.0.0
 *
 * @param string $area The area we want to get the colors for.
 * @param string $context Can be 'text' or 'accent'.
 * @return string Returns a HEX color.
 */
function cred_get_color_for_area( $area = 'content', $context = 'text' ) {

	// Get the value from the theme-mod.
	$settings = get_theme_mod(
		'accent_accessible_colors',
		array(
			'content'       => array(
				'text'      => '#000000',
				'accent'    => '#5d00ff',
				'secondary' => '#6d6d6d',
				'borders'   => '#dcd7ca'
			),
			'header-footer' => array(
				'text'      => '#000000',
				'accent'    => '#5d00ff',
				'secondary' => '#6d6d6d',
				'borders'   => '#dcd7ca'
			),
		)
	);

	// If we have a value return it.
	if ( isset( $settings[ $area ] ) && isset( $settings[ $area ][ $context ] ) ) :
		return $settings[ $area ][ $context ];
	endif;

	// Return false if the option doesn't exist.
	return false;
}

/**
 * Returns an array of variables for the customizer preview.
 *
 * @since 1.0.0
 *
 * @return array
 */
function cred_get_customizer_color_vars() {
	$colors = array(
		'content'       => array(
			'setting'   => 'background_color'
		)
	);
	return $colors;
}


/**
 * Returns the last paramter of the post item's excerpt.
 *
 * @since 1.0.0
 *
 * @return string $html
 */
if ( ! function_exists( 'cred_excerpt_more' ) ) :
	function cred_excerpt_more( $more ) {
		$more = '';
		if ( is_admin() ) :
			return $more;
		endif;

	    if ( ! is_single() ) :
	        $more = sprintf( '<a class="cred-read-more" href="%1$s">%2$s</a>',
	            get_permalink( get_the_ID() ),
	            __( 'Read More', 'credence' )
	        );
	    endif;
	 
	    return wp_kses_post( $more );
	}
endif;
add_filter( 'excerpt_more', 'cred_excerpt_more' );


/**
 * Google Fonts URL function
 *
 * @since 1.0.0
 *
 * @return string $URL
 */
if ( ! function_exists( 'cred_fonts_url' ) ) :
	function cred_fonts_url() {
		$fonts_url      = '';
		$all_fonts_list = cred_get_all_fonts();
		$header_font    = cred_sanitize_select( get_theme_mod( 'cred_header_google_font_list' ), $all_fonts_list );
		$heading_1_font = cred_sanitize_select( get_theme_mod( 'cred_heading_1_typo' ), $all_fonts_list );
		$heading_2_font = cred_sanitize_select( get_theme_mod( 'cred_heading_2_typo' ), $all_fonts_list );
		$heading_3_font = cred_sanitize_select( get_theme_mod( 'cred_heading_3_typo' ), $all_fonts_list );
		$heading_4_font = cred_sanitize_select( get_theme_mod( 'cred_heading_4_typo' ), $all_fonts_list );
		$heading_5_font = cred_sanitize_select( get_theme_mod( 'cred_heading_5_typo' ), $all_fonts_list );
		$heading_6_font = cred_sanitize_select( get_theme_mod( 'cred_heading_6_typo' ), $all_fonts_list );

	    if ( 'off' !== $header_font || 'off' !== $$heading_1_font  || 'off' !== $$heading_2_font  || 'off' !== $$heading_3_font  || 'off' !== $$heading_4_font  || 'off' !== $$heading_5_font  || 'off' !== $$heading_6_font ) :
	        $font_families = array();

	        if ( 'off' !== $header_font ) :
	            $font_families[] = $header_font;
	        endif;

	        if ( 'off' !== $heading_1_font ) :
	            $font_families[] = $heading_1_font;
	        endif;

	        if ( 'off' !== $heading_2_font ) :
	            $font_families[] = $heading_2_font;
	        endif;

	        if ( 'off' !== $heading_3_font ) :
	            $font_families[] = $heading_3_font;
	        endif;

	        if ( 'off' !== $heading_4_font ) :
	            $font_families[] = $heading_4_font;
	        endif;

	        if ( 'off' !== $heading_5_font ) :
	            $font_families[] = $heading_5_font;
	        endif;

	        if ( 'off' !== $heading_6_font ) :
	            $font_families[] = $heading_6_font;
	        endif;

	        $query_args = array(
	            'family' => urlencode( implode( '|', array_unique($font_families) ) ),
	        );

	        $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	    endif;

	    return esc_url_raw( $fonts_url );
	}
endif;


/**
 * Add color styling from theme
 */
function cred_customizer_style_method() {
	
	if( 'sidebar_none' !== get_theme_mod( 'cred_sidebar_position' ) ) :
		//content width
		$content_width = get_theme_mod( 'cred_content_width', 67 );
	else :
		$content_width = '100';
	endif;

	$custom = '';

	$all_fonts_list = cred_get_all_fonts();
	
	// body background
	$body_background           = get_theme_mod( 'cred_body_background_color', '#f3f3f3' );
	
	// content background color
	$content_background_color  = get_theme_mod( 'cred_content_background_color', '#ffffff' );
	
	// H1-h2 text color
	$heading_text_color        = get_theme_mod( 'cred_heading_text_color', '#000000' );
	
	// H1-h2 text color
	$heading_hover_text_color  = get_theme_mod( 'cred_heading_hover_text_color', '#000000' );
	
	// paragraph text color
	$paragraph_color           = get_theme_mod( 'cred_paragraph_color', '#707070' );
	
	// Link Color
	$link_color                = get_theme_mod( 'cred_link_color', '#6871FF' );
	$link_hover_color          = get_theme_mod( 'cred_link_hover_color', '#5d00ff' );
	
	//typography of heading
	$heading_1_typo            = cred_sanitize_select( get_theme_mod( 'cred_heading_1_typo' ), $all_fonts_list );
	$heading_1_font            = get_theme_mod( 'cred_heading_1_font', 42 );
	
	$heading_2_typo            = cred_sanitize_select( get_theme_mod( 'cred_heading_2_typo' ), $all_fonts_list );
	$heading_2_font            = get_theme_mod( 'cred_heading_2_font', 36 );
	
	$heading_3_typo            = cred_sanitize_select( get_theme_mod( 'cred_heading_3_typo' ), $all_fonts_list );
	$heading_3_font            = get_theme_mod( 'cred_heading_3_font', 30 );
	
	$heading_4_typo            = cred_sanitize_select( get_theme_mod( 'cred_heading_4_typo' ), $all_fonts_list );
	$heading_4_font            = get_theme_mod( 'cred_heading_4_font', 24 );
	
	$heading_5_typo            = cred_sanitize_select( get_theme_mod( 'cred_heading_5_typo' ), $all_fonts_list );
	$heading_5_font            = get_theme_mod( 'cred_heading_5_font', 20 );
	
	$heading_6_typo            = cred_sanitize_select( get_theme_mod( 'cred_heading_6_typo' ), $all_fonts_list );
	$heading_6_font            = get_theme_mod( 'cred_heading_6_font', 16 );
	
	//site width
	$site_width                = get_theme_mod( 'cred_site_width', '1140' );

	//header background color
	$header_background         = get_theme_mod( 'cred_header_background_color', '#ffffff' );
	
	//header text color
	$header_text               = get_theme_mod( 'cred_header_text_color', '#707070' );
	
	//header font
	$header_font               = cred_sanitize_select( get_theme_mod( 'cred_header_google_font_list' ), $all_fonts_list );

	//header submenu background color
	$header_submenu_background = get_theme_mod( 'cred_header_submenu_background_color', '#000000' );

	//header submenu background color
	$header_mobile_menu_bg     = get_theme_mod( 'cred_header_mobile_menu_background_color', '#ffffff' );
	
	//header submenu text color
	$header_submenu_text       = get_theme_mod( 'cred_header_submenu_text_color', '#ffffff' );
	
	//Sidebar Bg Color
	$sidebar_bg                = get_theme_mod( 'cred_sidebar_bg_color', '#ffffff' );
	//Sidebar border Color
	$sidebar_border_color      = get_theme_mod( 'cred_sidebar_border_color', '#e1e1e1' );
	
	//Footer background color customiser
	$footer_background         = get_theme_mod( 'cred_footer_background_color', '#222222' );
	//Footer copyright text color customiser
	$footer_text_color         = get_theme_mod( 'cred_footer_text_color', '#ffffff' );
	//Footer copyright link color customiser
	$footer_link_color         = get_theme_mod( 'cred_footer_link_color', '#ffffff' );
	//Footer widget background color customiser
	$footer_widget_background  = get_theme_mod( 'cred_footer_widget_background_color', '#ffffff' );
	
	// Footer Text Alignment
	$footer_align_item         = get_theme_mod( 'cred_footer_copy_align', 'center' );

	$custom .= '
	body {
        background : '. esc_attr( $body_background ) . ';
    }
    .cred-post {
        background: '. esc_attr( $content_background_color ) . ';
    }
    a, .widget_recent_entries a, .widget_archive a, .widget_categories a, .widget_pages a, .widget_meta a, .widget_recent_entries a, .widget_nav_menu a, .recentcomments a, .cred-read-more {
        color: '. esc_attr( $link_color ) . ';
    }
    .button, .faux-button, .wp-block-button__link, .wp-block-file .wp-block-file__button, input[type="button"], input[type="reset"], .comment-reply-link, input[type="submit"], .cred-read-more::after {
        background: '. esc_attr( $link_color ) . ';
    }
	blockquote {
		border-color: '. esc_attr( $link_color ) . ';
	}	
    a:hover, .entry-categories a:hover, .widget_recent_entries a:hover, .widget_archive a:hover, .widget_categories a:hover, .widget_pages a:hover, .widget_meta a:hover, .widget_recent_entries a:hover, .widget_nav_menu a:hover, .recentcomments a:hover, .cred-read-more:hover {
        color: '. esc_attr( $link_hover_color ) . ';
    }
    .button:hover, .faux-button:hover, .wp-block-button__link:hover, .wp-block-file .wp-block-file__button:hover, input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover {
        background: '. esc_attr( $link_hover_color ) . ';
    }
    .cred-read-more:hover::after {
        background: '. esc_attr( $link_hover_color ) . ';
    }
    h1, h2, h3, h4, h5, h6 {
        color: '. esc_attr( $heading_text_color ) . ';
    }
    .entry-title a:hover {
        color: '. esc_attr( $heading_hover_text_color ) . ';
    }
    .entry-content p, .entry-content li, .widget_text p, .widget_text ol, .widget_text ul, .widget_text dl, .widget_text dt, .widget-content .rssSummary {
        color: '. esc_attr( $paragraph_color ) . ';
    }
	h1 {
		font-size: '. esc_attr( $heading_1_font ) . 'px;
	}
	h2 {
		font-size: '. esc_attr( $heading_2_font ) . 'px;
	}
	h3 {
		font-size: '. esc_attr( $heading_3_font ) . 'px;
	}
	h4 {
		font-size: '. esc_attr( $heading_4_font ) . 'px;
	}
	h5 {
		font-size: '. esc_attr( $heading_5_font ) . 'px;
	}
	h6 {
		font-size: '. esc_attr( $heading_6_font ) . 'px;
	}
	#site-header,
	.cred-enable-sticky .cred-sticky-header-enable.fixed .cred-sticky-active,
	.cred-enable-transparent-header #site-header.fixed {
        background: '. esc_attr( $header_background ) . ';
        color: '. esc_attr( $header_text ) . ';
    }
	.site-title a,
	.site-description {
        color: '. esc_attr( $header_text ) . ';
    }
    .section-inner, #site-content {
        max-width: '. esc_attr( $site_width ) . 'px;
    }
    .modal-menu li a,
    body:not(.overlay-header) .primary-menu > li > a {
        color: '. esc_attr( $header_text ) . ';
    }
    .header-inner .toggle svg {
        fill: '. esc_attr( $header_text ) . ';
    }
    .primary-menu > li:not(.menu-item-has-children) > a::before, .primary-menu > li > .icon::before, .primary-menu > li > .icon::after,
    .header-inner .toggle-wrapper::before {
        background: '. esc_attr( $header_text ) . ';
    }
    body:not(.overlay-header) .primary-menu ul {
        background: '. esc_attr( $header_submenu_background ) . ';
        color: '. esc_attr( $header_submenu_text ) . ';
    }
    .primary-menu .icon::before, .primary-menu .icon::after {
        background: '. esc_attr( $header_submenu_text ) . ';
    }
    .sidebar-widget-area {
        background: '. esc_attr( $sidebar_bg ) . ';
    }

    .cred-main-container.col-lg-8 {
        flex: 0 0 '. esc_attr( $content_width ) . '%;
        max-width: '. esc_attr( $content_width ) . '%;
    }

    .cred-main-sidebar.col-lg-4 {
        flex: 0 0 calc( 100% - '. esc_attr( $content_width ) . '% );
        max-width: calc( 100% - '. esc_attr( $content_width ) . '% );
    }

    .cred-main-sidebar .widget:not(:last-child) {
        border-color: '. esc_attr( $sidebar_border_color ) . ';
    }
    #site-footer {
        background: '. esc_attr( $footer_background ) . ';
    }
    .footer-copyright {
        color: '. esc_attr( $footer_text_color ) . ';
    }
    .cred-footer-menu ul li a,
    .footer-copyright a {
        color: '. esc_attr( $footer_link_color ) . ';
    }
    .cred-footer-menu,
    .footer-copyright {
        text-align: '. esc_attr( $footer_align_item ) . ';
    }
    .footer-nav-widgets-wrapper {
        background: '. esc_attr( $footer_widget_background ) . ';
    }
    .menu-modal-inner {
    	background: '. esc_attr( $header_mobile_menu_bg ) . ';
    }
    @media (max-width: 999px) {
	    .cred-enable-transparent-header #site-header.fixed {
		    background: '. esc_attr( $header_background ) . ';
		}
	}
	';

	if ( isset( $header_font ) && ! empty( $header_font ) ) :
		$custom .= '
		body:not(.overlay-header) .primary-menu > li > a, 
		.modal-menu li a,
		.primary-menu ul a {
        	font-family: '. esc_attr( $header_font ) . ';
    	}';
	endif;

	if ( isset( $heading_1_typo ) && ! empty( $heading_1_typo ) ) :
		$custom .= '
		h1 {
        	font-family: '. esc_attr( $heading_1_typo ) . ';
    	}';
	endif;

	if ( isset( $heading_2_typo ) && ! empty( $heading_2_typo ) ) :
		$custom .= '
		h2 {
        	font-family: '. esc_attr( $heading_2_typo ) . ';
    	}';
	endif;

	if ( isset( $heading_3_typo ) && ! empty( $heading_3_typo ) ) :
		$custom .= '
		h3 {
        	font-family: '. esc_attr( $heading_3_typo ) . ';
    	}';
	endif;

	if ( isset( $heading_4_typo ) && ! empty( $heading_4_typo ) ) :
		$custom .= '
		h4 {
        	font-family: '. esc_attr( $heading_4_typo ) . ';
    	}';
	endif;

	if ( isset( $heading_5_typo ) && ! empty( $heading_5_typo ) ) :
		$custom .= '
		h5 {
        	font-family: '. esc_attr( $heading_5_typo ) . ';
    	}';
	endif;

	if ( isset( $heading_6_typo ) && ! empty( $heading_6_typo ) ) :
		$custom .= '
		h6 {
        	font-family: '. esc_attr( $heading_6_typo ) . ';
    	}';
	endif;

	wp_add_inline_style( 'cred-style', $custom );
}
add_action( 'wp_enqueue_scripts', 'cred_customizer_style_method' );

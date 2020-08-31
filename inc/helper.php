<?php

/**
 * get all google fonts
 */
if ( ! function_exists( 'cred_get_all_fonts' ) ) :
	function cred_get_all_fonts() {
		$googleApi = 'https://www.googleapis.com/webfonts/v1/webfonts?sort=alpha&key=AIzaSyDcAjGVgfOIeaMl5Ebppm2k65nmhKiXvu4';
		$fontContent = wp_remote_get( $googleApi, array('sslverify'   => false) );
		$content = json_decode($fontContent['body'], true);
		$cred_all_google_fonts_list = $content['items'];
		$cred_all_google_font_family_list = array_column( $cred_all_google_fonts_list, 'family' );
		$cred_all_google_font_array = array_combine( $cred_all_google_font_family_list, $cred_all_google_font_family_list );

		$custom_fonts = array(
			'Arial' => 'Arial',
			'Arial Black' => 'Arial Black',
			'Courier' => 'Courier',
			'Courier New' => 'Courier New',
			'Georgia' => 'Georgia',
			'Helvetica' => 'Helvetica',
			'Times' => 'Times',
			'Times New Roman' => 'Times New Roman',
			'Trebuchet MS' => 'Trebuchet MS',
			'Verdana' => 'Verdana'
		);

		$custom_fonts_list = apply_filters( 'cred_system_fonts', $custom_fonts );
		$all_fonts_list = array_merge( $custom_fonts_list, $cred_all_google_font_array );

		return $all_fonts_list;
	}
endif;


/**
 * Checkbox sanitization callback example.
 * 
 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
 * as a boolean value, either TRUE or FALSE.
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool Whether the checkbox is checked.
 */
if ( ! function_exists( 'cred_sanitize_checkbox' ) ) :
	function cred_sanitize_checkbox( $checked ) {
		// Boolean check.
		return ( ( isset( $checked ) && true == $checked ) ? true : false );
	}
endif;


/**
 * Select sanitization callback example.
 *
 * - Sanitization: select
 * - Control: select, radio
 * 
 * Sanitization callback for 'select' and 'radio' type controls. This callback sanitizes `$input`
 * as a slug, and then validates `$input` against the choices defined for the control.
 * 
 * @see sanitize_key()               https://developer.wordpress.org/reference/functions/sanitize_key/
 * @see $wp_customize->get_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/get_control/
 *
 * @param string               $input   Slug to sanitize.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string Sanitized slug if it is a valid choice; otherwise, the setting default.
 */
if ( ! function_exists( 'cred_sanitize_select' ) ) :
	function cred_sanitize_select( $input, $choices ) {

		$value = sanitize_text_field( $input );
		
		// If the input is a valid key, return it; otherwise, return the default.
		return ( in_array( $value, $choices ) ? $value : false );
	}
endif;

/**
 * Return selected homepage sidebar name.
 *
 * @return string
 */
if ( ! function_exists( 'cred_get_sidebar' ) ) :
	function cred_get_sidebar(){
	    $sidebar = get_theme_mod( 'cred_sidebar_position', 'sidebar_right' );
		$sidebar_is_set = isset( $sidebar ) ? $sidebar : '';
	    return $sidebar_is_set;
	}
endif;

/**
 * Get Footer widgets
 */
if ( ! function_exists( 'cred_get_footer_widget' ) ) :

	/**
	 * Get Footer Default Sidebar
	 *
	 * @param  string $sidebar_id   Sidebar Id..
	 * @return void
	 */
	function cred_get_footer_widget( $sidebar_id ) {

		if ( is_active_sidebar( $sidebar_id ) ) :
			dynamic_sidebar( $sidebar_id );
		elseif ( current_user_can( 'edit_theme_options' ) ) :

			global $wp_registered_sidebars;
			$sidebar_name = '';
			if ( isset( $wp_registered_sidebars[ $sidebar_id ] ) ) :
				$sidebar_name = $wp_registered_sidebars[ $sidebar_id ]['name'];
			endif;
			?>
			<div class="widget no-widget-row">
				<h2 class='no-widget-title'><?php echo esc_html( $sidebar_name ); ?></h2>

				<p class='no-widget-text'>
					<a href='<?php echo esc_url( admin_url( 'widgets.php' ) ); ?>'>
						<?php _e( 'Click here to assign a widget for this area.', 'credence' ); ?>
					</a>
				</p>
			</div>
			<?php
		endif;
	}
endif;


/**
 * post & page meta options
 */
add_action( 'admin_init', 'cred_post_and_page_custom_meta_options_init' );

function cred_post_and_page_custom_meta_options_init() {
  	add_meta_box( 'cred-page-settings-option', __( 'Credence Settings', 'credence' ), 'cred_page_custom_options', array( 'post', 'page' ), 'side', 'default' );
}

function cred_page_custom_options(){
  	global $post;
  	$custom                    = get_post_custom( $post->ID );
  	$sidebar_enable            = get_post_meta( $post->ID, 'cred_sidebar_status', true );
  	$transparent_header_enable = get_post_meta( $post->ID, 'cred_enable_transparent_header_status', true );

  	$title_status              = get_post_meta( $post->ID, 'cred_disable_title_status', true );
  	$featured_image_status     = get_post_meta( $post->ID, 'cred_disable_featured_image_status', true );
	$title_is_checked          = 1 == $title_status ? 'checked="checked"' : '';
	$image_is_checked          = 1 == $featured_image_status ? 'checked="checked"' : '';
  	?>

  	<div class="cred-page-settings-option-wrap">
	  	<div class="cred-page-sidebar-display-option-wrap">

		    <label for="cred_sidebar_status" class="post-attributes-label-wrapper"><strong><?php _e( 'Sidebar', 'credence' ); ?></strong></label>
		    <select name="cred_sidebar_status" id="cred_sidebar_status">
				<option value="default" <?php selected( $sidebar_enable, 'default' ); ?>> <?php _e( 'Customizer Setting', 'credence' ); ?></option>
				<option value="sidebar_left" <?php selected( $sidebar_enable, 'sidebar_left' ); ?>> <?php _e( 'Left Sidebar', 'credence' ); ?></option>
				<option value="sidebar_right" <?php selected( $sidebar_enable, 'sidebar_right' ); ?>> <?php _e( 'Right Sidebar', 'credence' ); ?></option>
				<option value="sidebar_none" <?php selected( $sidebar_enable, 'sidebar_none' ); ?>> <?php _e( 'No Sidebar', 'credence' ); ?></option>
		    </select>
		</div>

	  	<div class="cred-page-transparent-header-display-option-wrap">
		    <label for="cred_enable_transparent_header_status" class="post-attributes-label-wrapper"><strong><?php _e( 'Transparent Header', 'credence' ); ?></strong></label>
		    <select name="cred_enable_transparent_header_status" id="cred_enable_transparent_header_status">
				<option value="default" <?php selected( $transparent_header_enable, 'default' ); ?>> <?php _e( 'Customizer Setting', 'credence' ); ?></option>
				<option value="transparent_header" <?php selected( $transparent_header_enable, 'transparent_header' ); ?>> <?php _e( 'Enable Transparency', 'credence' ); ?></option>
		    </select>
		</div>

	  	<div class="cred-page-disable-section-option-wrap">
	  		<label><strong><?php _e( 'Disable Sections', 'credence' ); ?></strong></label>
		    
		    <div class="cred-page-title-display-option-wrap">
			    <label for="cred_disable_title_status" class="post-attributes-label-wrapper">
			    	<input type="checkbox" id="cred_disable_title_status" name="cred_disable_title_status" value="yes" <?php echo esc_attr( $title_is_checked ); ?> />
			    	<?php _e( 'Disable Title', 'credence' ); ?>
			    </label>
		    </div>

		    <div class="cred-page-feature-image-display-option-wrap">
			    <label for="cred_disable_featured_image_status" class="post-attributes-label-wrapper">
			    	<input type="checkbox" id="cred_disable_featured_image_status" name="cred_disable_featured_image_status" value="yes" <?php echo esc_attr( $image_is_checked ); ?> />
			    	<?php _e( 'Disable Featured Image', 'credence' ); ?>
			    </label>
		    </div>
	    </div>

	</div>    

  	<?php
}


/**
 * Save & Update Meta Details
 */
add_action( 'save_post', 'cred_save_post_and_page_details' );

function cred_save_post_and_page_details( $post_id ) {
  	global $post;

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) :
	    return $post->ID;
	endif;

	$sidebar_choices = array(
		'default',
		'sidebar_left',
		'sidebar_right',
		'sidebar_none'
	);

	$transparent_choices = array(
		'default',
		'transparent_header'
	);

	if( isset( $_POST['cred_sidebar_status'] ) ) :
  		update_post_meta( $post->ID, 'cred_sidebar_status', cred_sanitize_select( $_POST['cred_sidebar_status'], $sidebar_choices ) );
	endif;

	if( isset( $_POST['cred_enable_transparent_header_status'] ) ) :
  		update_post_meta( $post->ID, 'cred_enable_transparent_header_status', cred_sanitize_select( $_POST['cred_enable_transparent_header_status'], $transparent_choices ) );
	endif;

	if( isset( $_POST['cred_disable_title_status'] ) ) :
	    update_post_meta( $post->ID, 'cred_disable_title_status', cred_sanitize_checkbox( $_POST['cred_disable_title_status'] ) );
	else :
		delete_post_meta( $post_id, 'cred_disable_title_status' );
	endif;

	if( isset( $_POST['cred_disable_featured_image_status'] ) ) :
	    update_post_meta( $post->ID, 'cred_disable_featured_image_status', cred_sanitize_checkbox( $_POST['cred_disable_featured_image_status'] ) );
	else :
		delete_post_meta( $post_id, 'cred_disable_featured_image_status' );
	endif;
}


/**
 * Breadcrumb Class
 */

if ( ! class_exists( 'Cred_WP_Breadcrumb' ) ) :
	class Cred_WP_Breadcrumb {
		/**
		 * The list of breadcrumb items.
		 *
		 * @var array
		 * @since 1.0.0
		 */
		public $breadcrumb;
		/**
		 * Templates for link, current/standard state and before/after.
		 *
		 * @var array
		 */
		public $templates;
		/**
		 * Various strings.
		 *
		 * @var array
		 */
		public $strings;
		/**
		 * Various options.
		 *
		 * @var array
		 * @access public
		 */
		public $options;
		/**
		 * Constructor.
		 *
		 * @param array $templates An array with templates for link, current/standard state and before/after.
		 * @param array $options An array with options.
		 * @param array $strings An array with strings.
		 * @param bool $autorun Autorun or not.
		 * @return string
		 */
		public function __construct( $templates = array(), $options = array(), $strings = array(), $autorun = true ) {
			$this->templates = wp_parse_args(
				$templates,
				array(
					'link' 		=> '<a href="%s">%s</a>',
					'current' 	=> '<span class="c">%s</span>',
					'standard' 	=> '<span class="s">%s</span>',
					'before' 	=> '<nav>',
					'after' 	=> '</nav>'
				)
			);

			if( is_rtl() ) :
				$breadcrumb_separator = get_template_directory_uri().'/assets/images/chevron-left.png';
			else :
				$breadcrumb_separator = get_template_directory_uri().'/assets/images/chevron-right.png';
			endif;

			$this->options = wp_parse_args( $options, array(
				'separator' 		=> '<img src="'.esc_url( $breadcrumb_separator ).'">',
				'posts_on_front' 	=> 'posts' == get_option( 'show_on_front' ) ? true : false,
				'page_for_posts' 	=> get_option( 'page_for_posts' ),
				'show_pagenum' 		=> true, // support pagination
				'show_htfpt' 		=> false // show hierarchical terms for post types
			) );

			$this->strings = wp_parse_args( $strings, array(
				'home' 			=> esc_html__( 'Home', 'credence' ),
				'search' 		=> array(
					'singular' => esc_html__( 'Search results for %s', 'credence' ),
					'plural'   => esc_html__( '%1$s Search results for %1$s', 'credence' ),
				),
				'paged'	 	=> esc_html__( 'Page %d', 'credence' ),
				'404_error' => esc_html__( '404 Nothing Found', 'credence' ),
			) );

			// Generate breadcrumb
			if ( $autorun ) :
				echo wp_kses_post($this->output());
			endif;
		}

		/**
		 * Return the final breadcrumb.
		 *
		 * @return string
		 */
		public function output() {
			if ( empty( $this->breadcrumb ) )
				$this->generate();
			$breadcrumb = (string) implode( $this->options['separator'], $this->breadcrumb );
			return $this->templates['before'] . $breadcrumb . $this->templates['after'];
		}
		/**
		 * Build the item based on the type.
		 *
		 * @param string|array $item
		 * @param string $type
		 * @return string
		 */
		protected function template( $item, $type = 'standard' ) {
			if ( is_array( $item ) )
				$type = 'link';
			switch ( $type ) {
				case'link':
					return $this->template(
						sprintf(
							$this->templates['link'],
							esc_url( $item['link'] ),
							$item['title']
						)
					);
					break;
				case 'current':
					return sprintf( $this->templates['current'], $item );
					break;
				case 'standard':
					return sprintf( $this->templates['standard'], $item );
					break;
			}
		}
		/**
		 * Helper to generate taxonomy parents.
		 *
		 * @param mixed $term_id
		 * @param mixed $taxonomy
		 * @return void
		 */
		protected function generate_tax_parents( $term_id, $taxonomy ) {
			$parent_ids = array_reverse( get_ancestors( $term_id, $taxonomy ) );
			foreach ( $parent_ids as $parent_id ) {
				$term = get_term( $parent_id, $taxonomy );
				$this->breadcrumb["archive_{$taxonomy}_{$parent_id}"] = $this->template( array(
					'link' => get_term_link( $term->slug, $taxonomy ),
					'title' => $term->name
				) );
			}
		}

		/**
		 * Adds the items to the trail items array for search results.
		 *
		 * @since  1.0.0
		 * @access protected
		 * @return void
		 */
		protected function add_search_items() {

			if ( is_paged() )
				$this->items[] = sprintf( '<a href="%s">%s</a>', esc_url( get_search_link() ), sprintf( $this->labels['search'], get_search_query() ) );

			elseif ( true === $this->args['show_title'] )
				$this->items[] = sprintf( $this->labels['search'], get_search_query() );
		}

		/**
		 * Generate the breadcrumb.
		 *
		 * @return void
		 */
		public function generate() {
			$post_type = get_post_type();
			$queried_object = get_queried_object();
			$this->options['show_pagenum'] = ( $this->options['show_pagenum'] && is_paged() ) ? true : false;
			// Home & Front Page
			$this->breadcrumb['home'] = $this->template( $this->strings['home'], 'current' );
			$home_linked = $this->template( array(
				'link' => home_url( '/' ),
				'title' => $this->strings['home']
			) );
			if ( $this->options['posts_on_front'] ) {
				if ( ! is_home() || $this->options['show_pagenum'] )
					$this->breadcrumb['home'] = $home_linked;
			} else {
				if ( ! is_front_page() )
					$this->breadcrumb['home'] = $home_linked;
				if ( is_home() && !$this->options['show_pagenum'] )
					$this->breadcrumb['blog'] = $this->template( get_the_title( $this->options['page_for_posts'] ), 'current' );
				if ( ( 'post' == $post_type && ! is_search() && ! is_home() ) || ( 'post' == $post_type && $this->options['show_pagenum'] ) )
					$this->breadcrumb['blog'] = $this->template( array(
						'link' => get_permalink( $this->options['page_for_posts'] ),
						'title' => get_the_title( $this->options['page_for_posts'] )
					) );
			}
			// Post Type Archive as index
			if ( is_singular() || ( is_archive() && ! is_post_type_archive() ) || is_search() || $this->options['show_pagenum'] ) {
				if ( $post_type_link = get_post_type_archive_link( $post_type ) ) {
					$post_type_label = get_post_type_object( $post_type )->labels->name;
					$this->breadcrumb["archive_{$post_type}"] = $this->template(
						array(
						'link' => $post_type_link,
						'title' => $post_type_label
					) );
				}
			}
			if ( is_singular() ) { // Posts, (Sub)Pages, Attachments and Custom Post Types
				if ( ! is_front_page() ) {
					if ( $this->options['show_htfpt'] ) {
						$_id = $queried_object->ID;
						$_post_type = $post_type;
						if ( is_attachment() ) {
							// Show terms of the parent page
							$_id = $queried_object->post_parent;
							$_post_type = get_post_type( $_id );
						}
						$taxonomies = get_object_taxonomies( $_post_type, 'objects' );
						$taxonomies = array_values( wp_list_filter( $taxonomies, array(
							'hierarchical' => true
						) ) );
						if ( ! empty( $taxonomies ) ) {
							$taxonomy = $taxonomies[0]->name; // Get the first taxonomy
							$terms = get_the_terms( $_id, $taxonomy );
							if ( ! empty( $terms ) ) {
								$terms = array_values( $terms );
								$term = $terms[0]; // Get the first term
								if ( 0 != $term->parent )
									$this->generate_tax_parents( $term->term_id, $taxonomy );
								$this->breadcrumb["archive_{$taxonomy}"] = $this->template( array(
									'link' => get_term_link( $term->slug, $taxonomy ),
									'title' => $term->name
								) );
							}
						}
					}
					if ( 0 != $queried_object->post_parent ) { // Get Parents
						$parents = array_reverse( get_post_ancestors( $queried_object->ID ) );
						foreach ( $parents as $parent ) {
							$this->breadcrumb["archive_{$post_type}_{$parent}"] = $this->template( array(
								'link' => get_permalink( $parent ),
								'title' => get_the_title( $parent )
							) );
						}
					}
					$this->breadcrumb["single_{$post_type}"] = $this->template( get_the_title(), 'current' );
				}
			} elseif ( is_search() ) { // Search
				$this->add_search_items();
			} elseif ( is_archive() ) { // All archive pages
				if ( is_category() || is_tag() || is_tax() ) { // Categories, Tags and Custom Taxonomies
					$taxonomy = $queried_object->taxonomy;
					if ( 0 != $queried_object->parent && is_taxonomy_hierarchical( $taxonomy ) ) // Get Parents
						$this->generate_tax_parents( $queried_object->term_id, $taxonomy );
					$this->breadcrumb["archive_{$taxonomy}"] = $this->template( $queried_object->name, 'current' );
					if ( $this->options['show_pagenum'] )
						$this->breadcrumb["archive_{$taxonomy}"] = $this->template( array(
							'link' => get_term_link( $queried_object->slug, $taxonomy ),
							'title' => $queried_object->name
						) );
				} elseif ( is_date() ) { // Date archive
					if ( is_year() ) { // Year archive
						$this->breadcrumb['archive_year'] = $this->template( get_the_date( 'Y' ), 'current' );
						if ( $this->options['show_pagenum'] )
							$this->breadcrumb['archive_year'] = $this->template( array(
								'link' => get_year_link( get_query_var( 'year' ) ),
								'title' => get_the_date( 'Y' )
							) );
					} elseif ( is_month() ) { // Month archive
						$this->breadcrumb['archive_year'] = $this->template( array(
							'link' => get_year_link( get_query_var( 'year' ) ),
							'title' => get_the_date( 'Y' )
						) );
						$this->breadcrumb['archive_month'] = $this->template( get_the_date( 'F' ), 'current' );
						if ( $this->options['show_pagenum'] )
							$this->breadcrumb['archive_month'] = $this->template( array(
								'link' => get_month_link( get_query_var( 'year' ), get_query_var( 'monthnum' ) ),
								'title' => get_the_date( 'F' )
							) );
					} elseif ( is_day() ) { // Day archive
						$this->breadcrumb['archive_year'] = $this->template( array(
							'link' => get_year_link( get_query_var( 'year' ) ),
							'title' => get_the_date( 'Y' )
						) );
						$this->breadcrumb['archive_month'] = $this->template( array(
							'link' => get_month_link( get_query_var( 'year' ), get_query_var( 'monthnum' ) ),
							'title' => get_the_date( 'F' )
						) );
						$this->breadcrumb['archive_day'] = $this->template( get_the_date( 'j' ) );
						if ( $this->options['show_pagenum'] )
							$this->breadcrumb['archive_day'] = $this->template( array(
								'link' => get_month_link(
									get_query_var( 'year' ),
									get_query_var( 'monthnum' ),
									get_query_var( 'day' )
								),
								'title' => get_the_date( 'F' )
							) );
					}
				} elseif ( is_post_type_archive() && ! is_paged() ) { // Custom Post Type Archive
					$post_type_label = get_post_type_object( $post_type )->labels->name;
					$this->breadcrumb["archive_{$post_type}"] = $this->template( $post_type_label, 'current' );
				} elseif ( is_author() ) { // Author archive
					$this->breadcrumb['archive_author'] = $this->template( $queried_object->display_name, 'current' );
				}
			} elseif ( is_404() ) {
				$this->breadcrumb['404'] = $this->template( $this->strings['404_error'], 'current' );
			}
			if ( $this->options['show_pagenum'] )
				$this->breadcrumb['paged'] = $this->template(
					sprintf(
						$this->strings['paged'],
						get_query_var( 'paged' )
					),
					'current'
				);
		}
	}
endif;



/**
 * breadcrumb hooked in entry header
 */
add_action( 'cred_before_entry_header', 'cred_page_title' );
if( ! function_exists( 'cred_page_title' ) ) :
	function cred_page_title() {

		$cred_enable_breadcrumb = get_theme_mod( 'cred_enable_breadcrumb', 1 );

		if( $cred_enable_breadcrumb & is_singular( array( 'post', 'page' ) ) ) :
			echo '<div class="cred-breadcrumb-wrapper">';
				do_action( 'cred_breadcrumb' );
			echo '</div>';
		endif;

	}
endif;

/**
 * Setup breadcrumb
 */
add_action( 'cred_breadcrumb', 'cred_breadcrumb_setup' );
if( ! function_exists( 'cred_breadcrumb_setup' ) ) :
	function cred_breadcrumb_setup( $args = array() ){
		$breadcrumb_separator = '';
		if( is_rtl() ) :
			$breadcrumb_separator = get_template_directory_uri().'/assets/images/chevron-left.png';
		else :
			$breadcrumb_separator = get_template_directory_uri().'/assets/images/chevron-right.png';
		endif;
		$args = wp_parse_args( $args, apply_filters( 'cred_breadcrumb_defaults', array() ) );
		$options = array(
			'show_htfpt' => true,
			'separator'	 => '<img src="'.esc_url( $breadcrumb_separator ).'">'
		);

		if( class_exists( 'Cred_WP_Breadcrumb' ) ) :
			$breadcrumb = new Cred_WP_Breadcrumb( $args, $options );
		endif;
	}
endif;


/**
 * Breadcrumb $args
 */
add_filter( 'cred_breadcrumb_defaults', 'cred_breadcrumb_args' );
if( ! function_exists( 'cred_breadcrumb_args' ) ) :
	function cred_breadcrumb_args( $args = array() ) {
		$args = array(
			'before' 		=> '<nav class="cred-breadcrumb"><ul>',
			'after' 		=> '</ul></nav>',
			'standard' 		=> '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">%s</li>',
			'current' 		=> '<li class="current">%s</li>',
			'link' 			=> '<a href="%s" itemprop="url"><span itemprop="title">%s</span></a>'
		);
		return $args;
	}
endif;
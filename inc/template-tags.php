<?php
/**
 * Custom template tags for this theme.
 *
 * @package Credence
 * @since 1.0.0
 */

/**
 * Table of Contents:
 * Logo & Description
 * Comments
 * Post Meta
 * Menus
 * Classes
 * Archives
 * Miscellaneous
 */

/**
 * Logo & Description
 */
/**
 * Displays the site logo, either text or image.
 *
 * @param array   $args Arguments for displaying the site logo either as an image or text.
 * @param boolean $echo Echo or return the HTML.
 *
 * @return string $html Compiled HTML based on our arguments.
 */
if ( ! function_exists( 'cred_site_logo' ) ) :
	function cred_site_logo( $args = array(), $echo = true ) {
		$logo       = get_custom_logo();
		$site_title = get_bloginfo( 'name' );
		$contents   = '';
		$classname  = '';

		$defaults = array(
			'logo'        => '%1$s<span class="screen-reader-text">%2$s</span>',
			'logo_class'  => 'site-logo',
			'title'       => '<a href="%1$s">%2$s</a>',
			'title_class' => 'site-title',
			'home_wrap'   => '<h1 class="%1$s">%2$s</h1>',
			'logo_wrap'   => '<div class="%1$s">%2$s</div>',
			'single_wrap' => '<div class="%1$s faux-heading">%2$s</div>',
			'condition'   => ( is_front_page() || is_home() ) && ! is_page()
		);

		$args = wp_parse_args( $args, $defaults );

		/**
		 * Filters the arguments for `cred_site_logo()`.
		 *
		 * @param array  $args     Parsed arguments.
		 * @param array  $defaults Function's default arguments.
		 */
		$args = apply_filters( 'cred_site_logo_args', $args, $defaults );

		if ( has_custom_logo() ) :
			$contents  = sprintf( $args['logo'], $logo, esc_html( $site_title ) );
			$classname = $args['logo_class'];
			$wrap = $args['condition'] ? 'logo_wrap' : 'single_wrap';
		else :
			$contents  = sprintf( $args['title'], esc_url( get_home_url( null, '/' ) ), esc_html( $site_title ) );
			$classname = $args['title_class'];
			$wrap = $args['condition'] ? 'home_wrap' : 'single_wrap';
		endif;


		$html = sprintf( $args[ $wrap ], $classname, $contents );

		/**
		 * Filters the arguments for `cred_site_logo()`.
		 *
		 * @param string $html      Compiled html based on our arguments.
		 * @param array  $args      Parsed arguments.
		 * @param string $classname Class name based on current view, home or single.
		 * @param string $contents  HTML for site title or logo.
		 */
		$html = apply_filters( 'cred_site_logo', $html, $args, $classname, $contents );

		if ( ! $echo ) :
			return $html;
		endif;

		echo $html; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

/**
 * Displays the site description.
 *
 * @param boolean $echo Echo or return the html.
 *
 * @return string $html The HTML to display.
 */
if ( ! function_exists( 'cred_site_description' ) ) :
	function cred_site_description( $echo = true ) {
		$description = get_bloginfo( 'description' );

		if ( ! $description ) :
			return;
		endif;

		$wrapper = '<div class="site-description">%s</div><!-- .site-description -->';

		$html = sprintf( $wrapper, esc_html( $description ) );

		/**
		 * Filters the html for the site description.
		 *
		 * @since 1.0.0
		 *
		 * @param string $html         The HTML to display.
		 * @param string $description  Site description via `bloginfo()`.
		 * @param string $wrapper      The format used in case you want to reuse it in a `sprintf()`.
		 */
		$html = apply_filters( 'cred_site_description', $html, $description, $wrapper );

		if ( ! $echo ) :
			return $html;
		endif;

		echo $html; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

/**
 * Comments
 */
/**
 * Check if the specified comment is written by the author of the post commented on.
 *
 * @param object $comment Comment data.
 *
 * @return bool
 */
if ( ! function_exists( 'cred_is_comment_by_post_author' ) ) :
	function cred_is_comment_by_post_author( $comment = null ) {

		if ( is_object( $comment ) && $comment->user_id > 0 ) :
			$user = get_userdata( $comment->user_id );
			$post = get_post( $comment->comment_post_ID );

			if ( ! empty( $user ) && ! empty( $post ) ) :
				return $comment->user_id === $post->post_author;
			endif;
		endif;

		return false;
	}
endif;

/**
 * Filter comment reply link to not JS scroll.
 * Filter the comment reply link to add a class indicating it should not use JS slow-scroll, as it
 * makes it scroll to the wrong position on the page.
 *
 * @param string $link Link to the top of the page.
 *
 * @return string $link Link to the top of the page.
 */
if ( ! function_exists( 'cred_filter_comment_reply_link' ) ) :
	function cred_filter_comment_reply_link( $link ) {

		$link = str_replace( 'class=\'', 'class=\'do-not-scroll ', $link );
		return $link;

	}
endif;

add_filter( 'comment_reply_link', 'cred_filter_comment_reply_link' );

/**
 * Post Meta
 */
/**
 * Get and Output Post Meta.
 * If it's a single post, output the post meta values specified in the Customizer settings.
 *
 * @param int    $post_id The ID of the post for which the post meta should be output.
 * @param string $location Which post meta location to output – single or preview.
 */
if ( ! function_exists( 'cred_post_meta' ) ) :
	function cred_post_meta( $post_id = null, $location = 'single-top' ) {
		echo cred_get_post_meta( $post_id, $location ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in cred_get_post_meta().
	}
endif;

/**
 * Filters the edit post link to add an icon and use the post meta structure.
 *
 * @param string $link    Anchor tag for the edit link.
 * @param int    $post_id Post ID.
 * @param string $text    Anchor text.
 */
if ( ! function_exists( 'cred_edit_post_link' ) ) :
	function cred_edit_post_link( $link, $post_id, $text ) {
		if ( is_admin() ) :
			return $link;
		endif;

		$edit_url = get_edit_post_link( $post_id );

		if ( ! $edit_url ) :
			return;
		endif;

		$text = sprintf(
			wp_kses(
				/* translators: %s: Post title. Only visible to screen readers. */
				__( 'Edit <span class="screen-reader-text">%s</span>', 'credence' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title( $post_id )
		);

		return '<div class="post-meta-wrapper post-meta-edit-link-wrapper"><ul class="post-meta"><li class="post-edit meta-wrapper"><span class="meta-icon">' . cred_get_theme_svg( 'edit' ) . '</span><span class="meta-text"><a href="' . esc_url( $edit_url ) . '">' . $text . '</a></span></li></ul><!-- .post-meta --></div><!-- .post-meta-wrapper -->';

	}
endif;

add_filter( 'edit_post_link', 'cred_edit_post_link', 10, 3 );

/**
 * Get the post meta.
 *
 * @param int    $post_id The ID of the post.
 * @param string $location The location where the meta is shown.
 */
if ( ! function_exists( 'cred_get_post_meta' ) ) :
	function cred_get_post_meta( $post_id = null, $location = 'single-top' ) {

		// Require post ID.
		if ( ! $post_id ) :
			return;
		endif;

		/**
		 * Filters post types array
		 *
		 * This filter can be used to hide post meta information of post, page or custom post type registerd by child themes or plugins
		 *
		 * @since 1.0.0
		 *
		 * @param array Array of post types
		 */
		$disallowed_post_types = apply_filters( 'cred_disallowed_post_types_for_meta_output', array( 'page' ) );
		// Check whether the post type is allowed to output post meta.
		if ( in_array( get_post_type( $post_id ), $disallowed_post_types, true ) ) :
			return;
		endif;

		$post_meta_wrapper_classes = '';
		$post_meta_classes         = '';

		// Get the post meta settings for the location specified.
		if ( 'single-top' === $location ) :
			/**
			* Filters post meta info visibility
			*
			* Use this filter to hide post meta information like Author, Post date, Comments, Is sticky status
			*
			* @since 1.0.0
			*
			* @param array $args {
			*  @type string 'author'
			*  @type string 'post-date'
			*  @type string 'comments'
			*  @type string 'sticky'
			* }
			*/
			$post_meta = apply_filters(
				'cred_post_meta_location_single_top',
				array(
					'author',
					'post-date',
					'comments',
					'sticky',
				)
			);

			$post_meta_wrapper_classes = ' post-meta-single post-meta-single-top';

		elseif ( 'single-bottom' === $location ) :

			/**
			* Filters post tags visibility
			*
			* Use this filter to hide post tags
			*
			* @since 1.0.0
			*
			* @param array $args {
			*   @type string 'tags'
			* }
			*/
			$post_meta = apply_filters(
				'cred_post_meta_location_single_bottom',
				array(
					'tags',
				)
			);

			$post_meta_wrapper_classes = ' post-meta-single post-meta-single-bottom';

		endif;

		// If the post meta setting has the value 'empty', it's explicitly empty and the default post meta shouldn't be output.
		if ( $post_meta && ! in_array( 'empty', $post_meta, true ) ) :

			// Make sure we don't output an empty container.
			$has_meta = false;

			global $post;
			$the_post = get_post( $post_id );
			setup_postdata( $the_post );

			ob_start();

			?>

			<div class="post-meta-wrapper<?php echo esc_attr( $post_meta_wrapper_classes ); ?>">

				<ul class="post-meta<?php echo esc_attr( $post_meta_classes ); ?>">

					<?php

					/**
					 * Fires before post meta html display.
					 *
					 * Allow output of additional post meta info to be added by child themes and plugins.
					 *
					 * @since 1.0.0
					 * @since Credence 1.1 Added the `$post_meta` and `$location` parameters.
					 *
					 * @param int    $post_id   Post ID.
					 * @param array  $post_meta An array of post meta information.
					 * @param string $location  The location where the meta is shown.
					 *                          Accepts 'single-top' or 'single-bottom'.
					 */
					do_action( 'cred_start_of_post_meta_list', $post_id, $post_meta, $location );

					// Author.
					if ( in_array( 'author', $post_meta, true ) ) :

						$has_meta = true;
						?>
						<li class="post-author meta-wrapper">
							<span class="meta-icon">
								<span class="screen-reader-text"><?php _e( 'Post author', 'credence' ); ?></span>
								<?php cred_the_theme_svg( 'user' ); ?>
							</span>
							<span class="meta-text">
								<?php
								printf(
									/* translators: %s: Author name */
									__( 'By %s', 'credence' ),
									'<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author_meta( 'display_name' ) ) . '</a>'
								);
								?>
							</span>
						</li>
						<?php

					endif;

					// Post date.
					if ( in_array( 'post-date', $post_meta, true ) ) :

						$has_meta = true;
						?>
						<li class="post-date meta-wrapper">
							<span class="meta-icon">
								<span class="screen-reader-text"><?php _e( 'Post date', 'credence' ); ?></span>
								<?php cred_the_theme_svg( 'clock' ); ?>
							</span>
							<span class="meta-text">
								<a href="<?php the_permalink(); ?>"><?php the_time( get_option( 'date_format' ) ); ?></a>
							</span>
						</li>
						<?php

					endif;

					// Categories.
					if ( in_array( 'categories', $post_meta, true ) && has_category() ) :

						$has_meta = true;
						?>
						<li class="post-categories meta-wrapper">
							<span class="meta-icon">
								<span class="screen-reader-text"><?php _e( 'Categories', 'credence' ); ?></span>
								<?php cred_the_theme_svg( 'category' ); ?>
							</span>
							<span class="meta-text">
								<?php _ex( 'In', 'A string that is output before one or more categories', 'credence' ); ?> <?php the_category( ', ' ); ?>
							</span>
						</li>
						<?php

					endif;

					$tags_in_home = true;
					if( is_home() ) :
						$tags_in_home = get_theme_mod( 'cred_enable_tag_at_blog', true );
					endif;

					// Tags.
					if ( in_array( 'tags', $post_meta, true ) && has_tag() && true === $tags_in_home ) :

						$has_meta = true;
						?>
						<li class="post-tags meta-wrapper">
							<span class="meta-icon">
								<span class="screen-reader-text"><?php _e( 'Tags', 'credence' ); ?></span>
								<?php cred_the_theme_svg( 'tag' ); ?>
							</span>
							<span class="meta-text">
								<?php the_tags( '', ', ', '' ); ?>
							</span>
						</li>
						<?php

					endif;

					// Comments link.
					if ( in_array( 'comments', $post_meta, true ) && ! post_password_required() && ( comments_open() || get_comments_number() ) ) :

						$has_meta = true;
						?>
						<li class="post-comment-link meta-wrapper">
							<span class="meta-icon">
								<?php cred_the_theme_svg( 'comment' ); ?>
							</span>
							<span class="meta-text">
								<?php comments_popup_link(); ?>
							</span>
						</li>
						<?php

					endif;

					// Sticky.
					if ( in_array( 'sticky', $post_meta, true ) && is_sticky() ) :

						$has_meta = true;
						?>
						<li class="post-sticky meta-wrapper">
							<span class="meta-icon">
								<?php cred_the_theme_svg( 'bookmark' ); ?>
							</span>
							<span class="meta-text">
								<?php _e( 'Sticky post', 'credence' ); ?>
							</span>
						</li>
						<?php

					endif;

					/**
					 * Fires after post meta html display.
					 *
					 * Allow output of additional post meta info to be added by child themes and plugins.
					 *
					 * @since 1.0.0
					 * @since Credence 1.1 Added the `$post_meta` and `$location` parameters.
					 *
					 * @param int    $post_id   Post ID.
					 * @param array  $post_meta An array of post meta information.
					 * @param string $location  The location where the meta is shown.
					 *                          Accepts 'single-top' or 'single-bottom'.
					 */
					do_action( 'cred_end_of_post_meta_list', $post_id, $post_meta, $location );

					?>

				</ul><!-- .post-meta -->

			</div><!-- .post-meta-wrapper -->

			<?php

			wp_reset_postdata();

			$meta_output = ob_get_clean();

			// If there is meta to output, return it.
			if ( $has_meta && $meta_output ) :

				return $meta_output;

			endif;
		endif;

	}
endif;

/**
 * Menus
 */
/**
 * Filter Classes of wp_list_pages items to match menu items.
 * Filter the class applied to wp_list_pages() items with children to match the menu class, to simplify.
 * styling of sub levels in the fallback. Only applied if the match_menu_classes argument is set.
 *
 * @param array  $css_class CSS Class names.
 * @param string $item Comment.
 * @param int    $depth Depth of the current comment.
 * @param array  $args An array of arguments.
 * @param string $current_page Whether or not the item is the current item.
 *
 * @return array $css_class CSS Class names.
 */
if ( ! function_exists( 'cred_filter_wp_list_pages_item_classes' ) ) :
	function cred_filter_wp_list_pages_item_classes( $css_class, $item, $depth, $args, $current_page ) {

		// Only apply to wp_list_pages() calls with match_menu_classes set to true.
		$match_menu_classes = isset( $args['match_menu_classes'] );

		if ( ! $match_menu_classes ) :
			return $css_class;
		endif;

		// Add current menu item class.
		if ( in_array( 'current_page_item', $css_class, true ) ) :
			$css_class[] = 'current-menu-item';
		endif;

		// Add menu item has children class.
		if ( in_array( 'page_item_has_children', $css_class, true ) ) :
			$css_class[] = 'menu-item-has-children';
		endif;

		return $css_class;

	}
endif;
add_filter( 'page_css_class', 'cred_filter_wp_list_pages_item_classes', 10, 5 );

/**
 * Add a Sub Nav Toggle to the Expanded Menu and Mobile Menu.
 *
 * @param stdClass $args An array of arguments.
 * @param string   $item Menu item.
 * @param int      $depth Depth of the current menu item.
 *
 * @return stdClass $args An object of wp_nav_menu() arguments.
 */
if ( ! function_exists( 'cred_add_sub_toggles_to_main_menu' ) ) :
	function cred_add_sub_toggles_to_main_menu( $args, $item, $depth ) {

		// Add sub menu toggles to the Expanded Menu with toggles.
		if ( isset( $args->show_toggles ) && $args->show_toggles ) :

			// Wrap the menu item link contents in a div, used for positioning.
			$args->before = '<div class="ancestor-wrapper">';
			$args->after  = '';

			// Add a toggle to items with children.
			if ( in_array( 'menu-item-has-children', $item->classes, true ) ) :

				$toggle_target_string = '.menu-modal .menu-item-' . $item->ID . ' > .sub-menu';
				$toggle_duration      = cred_toggle_duration();

				// Add the sub menu toggle.
				$args->after .= '<button class="toggle sub-menu-toggle fill-children-current-color" data-toggle-target="' . $toggle_target_string . '" data-toggle-type="slidetoggle" data-toggle-duration="' . absint( $toggle_duration ) . '" aria-expanded="false"><span class="screen-reader-text">' . __( 'Show sub menu', 'credence' ) . '</span>' . cred_get_theme_svg( 'chevron-down' ) . '</button>';

			endif;

			// Close the wrapper.
			$args->after .= '</div><!-- .ancestor-wrapper -->';

			// Add sub menu icons to the primary menu without toggles.
		elseif ( 'primary' === $args->theme_location ) :
			if ( in_array( 'menu-item-has-children', $item->classes, true ) ) :
				$args->after = '<span class="icon"></span>';
			else :
				$args->after = '';
			endif;
		endif;

		return $args;

	}
endif;

add_filter( 'nav_menu_item_args', 'cred_add_sub_toggles_to_main_menu', 10, 3 );

/**
 * Classes
 */
/**
 * Add No-JS Class.
 * If we're missing JavaScript support, the HTML element will have a no-js class.
 */
if ( ! function_exists( 'cred_no_js_class' ) ) :
	function cred_no_js_class() {

		?>
		<script>document.documentElement.className = document.documentElement.className.replace( 'no-js', 'js' );</script>
		<?php

	}
endif;

add_action( 'wp_head', 'cred_no_js_class' );

/**
 * Add conditional body classes.
 *
 * @param array $classes Classes added to the body tag.
 *
 * @return array $classes Classes added to the body tag.
 */
if ( ! function_exists( 'cred_body_classes' ) ) :
	function cred_body_classes( $classes ) {

		global $post;
		$post_type = isset( $post ) ? $post->post_type : false;

		// Check whether we're singular.
		if ( is_singular() ) :
			$classes[] = 'singular';
		endif;

		// Check whether the current page has full-width content.
		if ( is_page_template( array( 'templates/template-full-width.php' ) ) ) :
			$classes[] = 'has-full-width-content';
		endif;

		// Check for enabled search.
		if ( true === get_theme_mod( 'cred_enable_header_search', true ) ) :
			$classes[] = 'enable-search-modal';
		endif;

		// Check for post thumbnail.
		if ( is_singular() && has_post_thumbnail() ) :
			$classes[] = 'has-post-thumbnail';
		elseif ( is_singular() ) :
			$classes[] = 'missing-post-thumbnail';
		endif;

		// Check whether we're in the customizer preview.
		if ( is_customize_preview() ) :
			$classes[] = 'customizer-preview';
		endif;

		// Check if posts have single pagination.
		if ( is_single() && ( get_next_post() || get_previous_post() ) ) :
			$classes[] = 'has-single-pagination';
		else :
			$classes[] = 'has-no-pagination';
		endif;

		// Check if we're showing comments.
		if ( $post && ( ( 'post' === $post_type || comments_open() || get_comments_number() ) && ! post_password_required() ) ) :
			$classes[] = 'showing-comments';
		else :
			$classes[] = 'not-showing-comments';
		endif;

		// Check if avatars are visible.
		$classes[] = get_option( 'show_avatars' ) ? 'show-avatars' : 'hide-avatars';

		// Slim page template class names (class = name - file suffix).
		if ( is_page_template() ) :
			$classes[] = basename( get_page_template_slug(), '.php' );
		endif;

		// Check for the elements output in the top part of the footer.
		$has_footer_menu = has_nav_menu( 'footer' );
		$has_sidebar_1   = is_active_sidebar( 'sidebar-1' );
		$has_sidebar_2   = is_active_sidebar( 'sidebar-2' );

		// Add a class indicating whether those elements are output.
		if ( $has_footer_menu || $has_sidebar_1 || $has_sidebar_2 ) :
			$classes[] = 'footer-top-visible';
		else :
			$classes[] = 'footer-top-hidden';
		endif;

		if ( $has_footer_menu ) :
			$classes[] = 'footer-menu-added';
		endif;

		if ( true === get_theme_mod( 'cred_enable_header_sticky', true ) ) :
			$classes[] = 'cred-enable-sticky';
		else :
			$classes[] = 'cred-disable-sticky';
		endif;

		if ( true === get_theme_mod( 'cred_enable_transparent_header', false ) ) :
			$classes[] = 'cred-enable-transparent-header';
		else :
			$classes[] = 'cred-disable-transparent-header';
		endif;

		if( is_singular() ) :
			$transparent_header = get_post_meta( $post->ID, 'cred_enable_transparent_header_status', true );
			if ( 'transparent_header' === $transparent_header ) :
				$classes[] = 'cred-enable-transparent-header';
			endif;
		endif;

		return $classes;

	}
endif;

add_filter( 'body_class', 'cred_body_classes' );

/**
 * Archives
 */
/**
 * Filters the archive title and styles the word before the first colon.
 *
 * @param string $title Current archive title.
 *
 * @return string $title Current archive title.
 */
if ( ! function_exists( 'cred_get_the_archive_title' ) ) :
	function cred_get_the_archive_title( $title ) {

		$regex = apply_filters(
			'cred_get_the_archive_title_regex',
			array(
				'pattern'     => '/(\A[^\:]+\:)/',
				'replacement' => '<span class="color-accent">$1</span>',
			)
		);

		if ( empty( $regex ) ) :
			return $title;
		endif;

		return preg_replace( $regex['pattern'], $regex['replacement'], $title );

	}
endif;

add_filter( 'get_the_archive_title', 'cred_get_the_archive_title' );

/**
 * Miscellaneous
 */
/**
 * Toggle animation duration in milliseconds.
 *
 * @return integer Duration in milliseconds
 */
if ( ! function_exists( 'cred_toggle_duration' ) ) :
	function cred_toggle_duration() {
		/**
		 * Filters the animation duration/speed used usually for submenu toggles.
		 *
		 * @since 1.0
		 *
		 * @param integer $duration Duration in milliseconds.
		 */
		$duration = apply_filters( 'cred_toggle_duration', 250 );

		return $duration;
	}
endif;

/**
 * Get unique ID.
 *
 * This is a PHP implementation of Underscore's uniqueId method. A static variable
 * contains an integer that is incremented with each call. This number is returned
 * with the optional prefix. As such the returned value is not universally unique,
 * but it is unique across the life of the PHP process.
 *
 * @see wp_unique_id() Themes requiring WordPress 5.0.3 and greater should use this instead.
 *
 * @staticvar int $id_counter
 *
 * @param string $prefix Prefix for the returned ID.
 * @return string Unique ID.
 */
if ( ! function_exists( 'cred_unique_id' ) ) :
	function cred_unique_id( $prefix = '' ) {
		static $id_counter = 0;
		if ( function_exists( 'wp_unique_id' ) ) :
			return wp_unique_id( $prefix );
		endif;
		return $prefix . (string) ++$id_counter;
	}
endif;

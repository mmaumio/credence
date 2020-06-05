<?php
/**
 * Displays the post header
 *
 * @package Credence
 * @since 1.0.0
 */

$categories_in_home = true;
if( is_home() ) :
	$categories_in_home = get_theme_mod( 'cred_enable_category_at_blog', true );
endif;
?>

<header class="entry-header">

	<div class="entry-header-inner medium">

		<?php
			/**
			 * Allow child themes and plugins to filter the display of the categories in the entry header.
			 *
			 * @since 1.0.0
			 *
			 * @param bool   Whether to show the categories in header, Default true.
			 */
			do_action( 'cred_before_entry_header' );
			
			$categories_in_single_post = apply_filters( 'cred_show_categories_in_single_post', true );

			if ( true === $categories_in_single_post && true === $categories_in_home && has_category() ) :
				?>

				<div class="entry-categories">
					<span class="screen-reader-text"><?php _e( 'Categories', 'credence' ); ?></span>
					<div class="entry-categories-inner">
						<span><?php cred_the_theme_svg( 'category' ); ?></span>
						<span><?php the_category( ' ' ); ?></span>
					</div><!-- .entry-categories-inner -->
				</div><!-- .entry-categories -->

				<?php
			endif;

			if ( is_singular() ) :
				global $post;
				$cred_title_disable = get_post_meta( $post->ID, 'cred_disable_title_status', true );
				if( 1 != $cred_title_disable ) :
					the_title( '<h1 class="entry-title">', '</h1>' );
				endif;
			else :
				the_title( '<h2 class="entry-title heading-size-1"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' );
			endif;

			$intro_text_width = '';

			if ( is_singular() ) :
				$intro_text_width = ' small';
			else :
				$intro_text_width = ' thin';
			endif;

			if ( has_excerpt() && is_singular() ) :
				?>

				<div class="intro-text section-inner max-percentage<?php echo $intro_text_width; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output ?>">
					<?php the_excerpt(); ?>
				</div>

				<?php
			endif;

			// Default to displaying the post meta.
			cred_post_meta( get_the_ID(), 'single-top' );

			do_action( 'cred_after_entry_header' );
		?>

	</div><!-- .entry-header-inner -->

</header><!-- .entry-header -->

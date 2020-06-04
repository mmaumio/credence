<?php
/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Credence
 * @since 1.0.0
 */

?>

<article <?php post_class( 'cred-post' ); ?> id="post-<?php the_ID(); ?>">
	<?php

	get_template_part( 'template-parts/entry-header' );

	if ( ! is_search() ) :
		get_template_part( 'template-parts/featured-image' );
	endif;

	?>
	<div class="post-inner <?php echo is_page_template( 'templates/template-full-width.php' ) ? '' : 'thin'; ?> ">

		<div class="entry-content">

			<?php
			if ( is_search() || ! is_singular() && 'summary' === get_theme_mod( 'cred_blog_content', 'summary' ) ) :
				the_excerpt();
			else :
				the_content( __( 'Continue reading', 'credence' ) );
			endif;
			?>

		</div><!-- .entry-content -->

	</div><!-- .post-inner -->

	<div class="cred-page-footer-content">
		<?php
		wp_link_pages(
			array(
				'before'      => '<nav class="post-nav-links bg-light-background" aria-label="' . esc_attr__( 'Page', 'credence' ) . '"><span class="label">' . __( 'Pages:', 'credence' ) . '</span>',
				'after'       => '</nav>',
				'link_before' => '<span class="page-number">',
				'link_after'  => '</span>'
			)
		);

		edit_post_link();

		// Single bottom post meta.
		cred_post_meta( get_the_ID(), 'single-bottom' );

		if ( is_single() ) :
			get_template_part( 'template-parts/navigation' );
		endif;

		/**
		 *  Output comments wrapper if it's a post, or if comments are open,
		 * or if there's a comment number – and check for password.
		 * */
		if ( ( is_single() || is_page() ) && ( comments_open() || get_comments_number() ) && ! post_password_required() ) :
			?>

			<div class="comments-wrapper">

				<?php comments_template(); ?>

			</div><!-- .comments-wrapper -->

			<?php
		endif;
		?>

	</div><!-- .section-inner -->

</article><!-- .post -->

<?php 
	if ( is_single() ) {
		get_template_part( 'template-parts/entry-author-bio' );
	}
?>

<?php get_template_part( 'template-parts/related-post' ); ?>


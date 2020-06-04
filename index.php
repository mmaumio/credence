<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Credence
 * @since 1.0.0
 */

get_header();
?>

<div id="site-content" class="cred-single-post-container row">

<?php 
	$sidebar_position = cred_get_sidebar();
	if ( 'sidebar_left' === $sidebar_position ) :
    	get_sidebar();
	endif;
	if ( 'sidebar_right' === $sidebar_position || 'sidebar_left' === $sidebar_position ) :
		$center_column_width = 'col-lg-8';
	else :
		$center_column_width = 'col-lg-12';
	endif;
?>

	<div class="cred-main-container <?php echo esc_attr( $center_column_width ); ?>">
		<?php

		$archive_title    = '';
		$archive_subtitle = '';

		if ( is_search() ) :
			global $wp_query;

			$archive_title = sprintf(
				'%1$s %2$s',
				'<span class="color-accent">' . __( 'Search:', 'credence' ) . '</span>',
				'&ldquo;' . get_search_query() . '&rdquo;'
			);

			if ( $wp_query->found_posts ) :
				$archive_subtitle = sprintf(
					/* translators: %s: Number of search results */
					_n(
						'We found %s result for your search.',
						'We found %s results for your search.',
						$wp_query->found_posts,
						'credence'
					),
					number_format_i18n( $wp_query->found_posts )
				);
			else :
				$archive_subtitle = __( 'We could not find any results for your search. You can give it another try through the search form below.', 'credence' );
			endif;
		elseif ( ! is_home() ) :
			$archive_title    = get_the_archive_title();
			$archive_subtitle = get_the_archive_description();
		endif;

		if ( $archive_title || $archive_subtitle ) :
			?>
			<header class="archive-header">
				<div class="archive-header-inner section-inner medium">
					<?php if ( $archive_title ) : ?>
						<h1 class="archive-title"><?php echo wp_kses_post( $archive_title ); ?></h1>
					<?php endif; ?>
					<?php if ( $archive_subtitle ) : ?>
						<div class="archive-subtitle section-inner thin max-percentage intro-text"><?php echo wp_kses_post( wpautop( $archive_subtitle ) ); ?></div>
					<?php endif; ?>
				</div><!-- .archive-header-inner -->
			</header><!-- .archive-header -->
		<?php
		endif;

		if ( have_posts() ) :
			$i = 0;
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', get_post_type() );
			endwhile;
		elseif ( is_search() ) :
		?>
			<div class="no-search-results-form section-inner thin">
				<?php
					get_search_form(
						array(
							'label' => __( 'search again', 'credence' )
						)
					);
				?>
			</div><!-- .no-search-results -->
			<?php
		endif;
		?>
		<?php get_template_part( 'template-parts/pagination' ); ?>
	</div>

<?php if ( 'sidebar_right' === $sidebar_position ) : ?>
    <?php get_sidebar(); ?>
<?php endif; ?>

</div><!-- #site-content -->

<?php
get_footer();

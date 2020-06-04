<?php
/**
 * A template partial to output pagination for the Credence default theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Credence
 * @since 1.0.0
 */

/**
 * Translators:
 * This text contains HTML to allow the text to be shorter on small screens.
 * The text inside the span with the class nav-short will be hidden on small screens.
 */
$cred_pagination_prev_icon = is_rtl() ? '&rarr;' : '&larr;';
$prev_text = sprintf(
	'<span aria-hidden="true">%s</span> <span class="nav-prev-text">%s</span>',
	$cred_pagination_prev_icon,
	__( 'Newer <span class="nav-short">Posts</span>', 'credence' )
);

$cred_pagination_next_icon = is_rtl() ? '&larr;' : '&rarr;';
$next_text = sprintf(
	'<span class="nav-next-text">%s</span> <span aria-hidden="true">%s</span>',
	__( 'Older <span class="nav-short">Posts</span>', 'credence' ),
	$cred_pagination_next_icon
);

$posts_pagination = get_the_posts_pagination(
	array(
		'mid_size'  => 1,
		'prev_text' => $prev_text,
		'next_text' => $next_text
	)
);

// If we're not outputting the previous page link, prepend a placeholder with visibility: hidden to take its place.
if ( strpos( $posts_pagination, 'prev page-numbers' ) === false ) :
	$posts_pagination = str_replace( '<div class="nav-links">', '<div class="nav-links"><span class="prev page-numbers placeholder" aria-hidden="true">' . $prev_text . '</span>', $posts_pagination );
endif;

// If we're not outputting the next page link, append a placeholder with visibility: hidden to take its place.
if ( strpos( $posts_pagination, 'next page-numbers' ) === false ) :
	$posts_pagination = str_replace( '</div>', '<span class="next page-numbers placeholder" aria-hidden="true">' . $next_text . '</span></div>', $posts_pagination );
endif;

if ( $posts_pagination ) : ?>

	<div class="pagination-wrapper section-inner">

		<?php echo $posts_pagination; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- already escaped during generation. ?>

	</div><!-- .pagination-wrapper -->

	<?php
endif;

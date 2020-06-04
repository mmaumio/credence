<?php
/**
 * Displays the next and previous post navigation in single posts.
 *
 * @package Credence
 * @since 1.0.0
 */

$next_post = get_next_post();
$prev_post = get_previous_post();

if ( $next_post || $prev_post ) :

	$pagination_classes = '';

	if ( ! $next_post ) :
		$pagination_classes = ' only-one only-prev';
	elseif ( ! $prev_post ) :
		$pagination_classes = ' only-one only-next';
	endif;
	$cred_navigation_prev_icon = is_rtl() ? '&rarr;' : '&larr;';
	$cred_navigation_next_icon = is_rtl() ? '&larr;' : '&rarr;';
	?>

	<nav class="pagination-single section-inner<?php echo $pagination_classes; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output ?>" aria-label="<?php esc_attr_e( 'Post', 'credence' ); ?>" role="navigation">

		<div class="pagination-single-inner">

			<?php
			if ( $prev_post ) :
				?>

				<a class="previous-post" href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>">
					<span class="arrow" aria-hidden="true"><?php echo $cred_navigation_prev_icon; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output ?></span>
					<span class="title"><span class="title-inner"><?php echo wp_kses_post( get_the_title( $prev_post->ID ) ); ?></span></span>
				</a>

				<?php
			endif;

			if ( $next_post ) :
				?>

				<a class="next-post" href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>">
					<span class="arrow" aria-hidden="true"><?php echo $cred_navigation_next_icon; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output ?></span>
					<span class="title"><span class="title-inner"><?php echo wp_kses_post( get_the_title( $next_post->ID ) ); ?></span></span>
				</a>
				<?php
			endif;
			?>

		</div><!-- .pagination-single-inner -->

	</nav><!-- .pagination-single -->

	<?php
endif;

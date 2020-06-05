<?php
/**
 * Displays the featured image
 *
 * @package Credence
 * @since 1.0.0
 */
global $post;
$cred_featured_image_disable = get_post_meta( $post->ID, 'cred_disable_featured_image_status', true );

if ( has_post_thumbnail() && ! post_password_required() && 1 != $cred_featured_image_disable ) :

	$featured_media_inner_classes = '';

	// Make the featured media thinner on archive pages.
	if ( ! is_singular() ) :
		$featured_media_inner_classes .= ' medium';
	endif;
	?>

	<figure class="featured-media">

		<div class="featured-media-inner section-inner<?php echo $featured_media_inner_classes; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output ?>">

			<?php
			the_post_thumbnail( 'cred-post-thumb' );

			$caption = get_the_post_thumbnail_caption();

			if ( $caption ) :
				?>

				<figcaption class="wp-caption-text"><?php echo wp_kses_post( $caption ); ?></figcaption>

				<?php
			endif;
			?>

		</div><!-- .featured-media-inner -->

	</figure><!-- .featured-media -->

	<?php
endif;

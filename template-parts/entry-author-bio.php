<?php
/**
 * The template for displaying Author info
 *
 * @package Credence
 * @since 1.0.0
 */

if ( (bool) get_the_author_meta( 'description' ) && (bool) get_theme_mod( 'cred_show_author_bio', true ) ) : ?>
	<div class="cred-post">
		<div class="author-bio">
			<div class="author-title-wrapper">
				<div class="author-avatar vcard">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), apply_filters( 'cred_author_avatar_size', 160 ) ); ?>
				</div>
				<h4 class="author-title heading-size-4">
					<?php
					printf(
						/* translators: %s: Author name */
						__( 'By %s', 'credence' ),
						esc_html( get_the_author() )
					);
					?>
				</h4>
			</div><!-- .author-name -->
			<div class="author-description">
				<?php 
					echo wp_kses_post( wpautop( get_the_author_meta( 'description' ) ) ); 
					$cred_author_bio_icon = ! is_rtl() ? '&rarr;' : '&larr;';
				?>
				<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
				<?php _e( 'View Archive ', 'credence' ); ?><span aria-hidden="true"><?php echo $cred_author_bio_icon; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output ?></span>
				</a>
			</div><!-- .author-description -->
		</div><!-- .author-bio -->
	</div>	
<?php endif; ?>

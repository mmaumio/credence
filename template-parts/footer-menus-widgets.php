<?php
/**
 * Displays the menus and widgets at the end of the main element.
 * Visually, this output is presented as part of the footer element.
 *
 * @package Credence
 * @since 1.0.0
 */

$footer_layout = get_theme_mod( 'cred_footer_layout', 'footer_col_four' );

if ( 'footer_col_one' === $footer_layout ) :
	$footer_col = 'col-lg-12';
elseif( 'footer_col_two' === $footer_layout ) :
	$footer_col = 'col-lg-6';
elseif( 'footer_col_three' === $footer_layout ) :
	$footer_col = 'col-lg-4';
elseif( 'footer_col_four' === $footer_layout ) :
	$footer_col = 'col-lg-3';
endif;
?>


<?php if( 'footer_widget_none' !== $footer_layout ) : ?>
	<?php if ( is_active_sidebar( 'footer-one' ) ||  is_active_sidebar( 'footer-two' ) ||  is_active_sidebar( 'footer-three' ) ||  is_active_sidebar( 'footer-four' ) ) : ?>
		<div class="footer-nav-widgets-wrapper">

			<div class="footer-inner section-inner">
				<div class="row">

					<?php if ( is_active_sidebar( 'footer-one' ) ) : ?>
						<div class="footer-widgets <?php echo esc_attr( $footer_col ); ?>">
							<?php cred_get_footer_widget( 'footer-one' ); ?>
						</div>
					<?php endif; ?>

					<?php if ( is_active_sidebar( 'footer-two' ) ) : ?>
						<?php if( $footer_layout === 'footer_col_two' || $footer_layout === 'footer_col_three' || $footer_layout === 'footer_col_four' ) : ?>
							<div class="footer-widgets <?php echo esc_attr( $footer_col ); ?>">
								<?php cred_get_footer_widget( 'footer-two' ); ?>
							</div>
						<?php endif; ?>
					<?php endif; ?>

					<?php if ( is_active_sidebar( 'footer-three' ) ) : ?>
						<?php if( $footer_layout === 'footer_col_three' || $footer_layout === 'footer_col_four' ) : ?>
							<div class="footer-widgets <?php echo esc_attr( $footer_col ); ?>">
								<?php cred_get_footer_widget( 'footer-three' ); ?>
							</div>
						<?php endif; ?>
					<?php endif; ?>
					
					<?php if ( is_active_sidebar( 'footer-four' ) ) : ?>
						<?php if( $footer_layout === 'footer_col_four' ) : ?>
							<div class="footer-widgets <?php echo esc_attr( $footer_col ); ?>">
								<?php cred_get_footer_widget( 'footer-four' ); ?>
							</div>
						<?php endif; ?>
					<?php endif; ?>

				</div><!-- .row -->
			</div><!-- .footer-inner -->

		</div><!-- .footer-nav-widgets-wrapper -->
	<?php endif; ?>
<?php endif; ?>

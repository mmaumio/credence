<?php
/**
 * The template for displaying the footer
 *
 * Contains the opening of the #site-footer div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Credence
 * @since 1.0.0
 */ 
?>
	</main> <!-- End #content -->

		<?php	
			$has_footer_menu    = has_nav_menu( 'footer' );
			$cred_enable_footer_menu = get_theme_mod( 'cred_enable_footer_menu', 'yes' );
		
			get_template_part( 'template-parts/footer-menus-widgets' );
		?>
			<footer id="site-footer" role="contentinfo">
				<div class="section-inner cred-footer-bottom-part">
					<div class="section-inner row">
						<?php
							if( $has_footer_menu && $cred_enable_footer_menu ) :
						?>
							<div class="cred-footer-menu col-lg-12">
								<?php 
									wp_nav_menu( array(
										'theme_location'  => 'footer',
										'depth' 	      => 1,
										'menu_id'         => 'footer-menu',
										'container'       => 'nav',
										'container_class' => 'navbar',
										'container_id' 	  => 'nav',
										'menu_class'      => 'navbar-nav'
									) );
								?>

							</div><!-- .footer-credits -->
						<?php endif; ?>

						<div class="footer-copyright col-lg-12">
						<?php 
							$footer_credit = __( 'Credence Powered by WordPress', 'credence' );
							$footer_text = get_theme_mod( 'cred_footer_text', $footer_credit );
							if( isset( $footer_text ) || ! empty( $footer_text ) ) :
								echo wp_kses_post( $footer_text );
							endif;
						?>
						</div>

						<a class="to-the-top" href="#">
							<span class="to-the-top-long">
								<?php
								/* translators: %s: HTML character for up arrow */
								printf( __( '%s', 'credence' ), '<span class="arrow" aria-hidden="true">&uarr;</span>' );
								?>
							</span><!-- .to-the-top-long -->
							<span class="to-the-top-short">
								<?php
								/* translators: %s: HTML character for up arrow */
								printf( __( '%s', 'credence' ), '<span class="arrow" aria-hidden="true">&uarr;</span>' );
								?>
							</span><!-- .to-the-top-short -->
						</a><!-- .to-the-top -->
					</div><!-- .section-inner -->
				</div><!-- .section-inner -->

			</footer><!-- #site-footer -->

		<?php wp_footer(); ?>

	</body>
</html>

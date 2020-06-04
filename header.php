<?php
/**
 * Header file for the Credence WordPress default theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Credence
 * @since 1.0.0
 */

?><!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" >
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
	wp_body_open();
	$cred_header_is_sticky = get_theme_mod( 'cred_enable_header_sticky', true );
	$cred_sticky_type = '';
	$cred_with_sticky = '';
	if( true === $cred_header_is_sticky ) :
		$cred_sticky_type = 'enable';
		$cred_with_sticky = '-sticky';
	else :
		$cred_sticky_type = 'disable';
		$cred_with_sticky = 'out-sticky';
	endif;
?>
<header id="site-header" class="cred-sticky-header-<?php echo esc_attr( $cred_sticky_type); ?>" role="banner" >
	<div class="cred-main-header-bar-with<?php echo esc_attr( $cred_with_sticky );?>">
		<div class="header-inner section-inner">
			<div class="header-titles-wrapper">
				<?php
				// Check whether the header search is activated in the customizer.
				$cred_enable_header_search = get_theme_mod( 'cred_enable_header_search', true );

				if ( true === $cred_enable_header_search ) :
					?>
					<button class="toggle search-toggle mobile-search-toggle" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false">
						<span class="toggle-inner">
							<span class="toggle-icon">
								<?php cred_the_theme_svg( 'search' ); ?>
							</span>
						</span>
					</button><!-- .search-toggle -->
				<?php endif; ?>

				<div class="header-titles">
					<?php
						$cred_site_tagline = get_theme_mod( 'cred_enable_site_tagline', true );
						// Site title or logo.
						cred_site_logo();

						// Site description.
						if( true === $cred_site_tagline ) :
							cred_site_description();
						endif;
					?>
				</div><!-- .header-titles -->

				<button class="toggle nav-toggle mobile-nav-toggle" data-toggle-target=".menu-modal"  data-toggle-body-class="showing-menu-modal" aria-expanded="false" data-set-focus=".close-nav-toggle">
					<span class="toggle-inner">
						<span class="toggle-icon">
							<?php cred_the_theme_svg( 'hamburger-menu' ); ?>
						</span>
					</span>
				</button><!-- .nav-toggle -->
			</div><!-- .header-titles-wrapper -->

			<div class="header-navigation-wrapper">

				<?php
				if ( has_nav_menu( 'primary' ) ) :
					?>
					<nav class="primary-menu-wrapper" aria-label="<?php esc_attr_e( 'Horizontal', 'credence' ); ?>" role="navigation">
						<ul class="primary-menu reset-list-style">
						<?php
						wp_nav_menu(
							array(
								'container'      => '',
								'items_wrap'     => '%3$s',
								'theme_location' => 'primary'
							)
						);
						?>
						</ul>
					</nav><!-- .primary-menu-wrapper -->
					<?php
				endif;

				if ( true === $cred_enable_header_search ) :
					?>
					<div class="header-toggles hide-no-js">
					<?php
					if ( true === $cred_enable_header_search ) : ?>
						<div class="toggle-wrapper search-toggle-wrapper">
							<button class="toggle search-toggle desktop-search-toggle" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false">
								<span class="toggle-inner">
									<?php cred_the_theme_svg( 'search' ); ?>
								</span>
							</button><!-- .search-toggle -->
						</div>
					<?php endif; ?>
					</div><!-- .header-toggles -->
				<?php
				endif;
				?>
			</div><!-- .header-navigation-wrapper -->
		</div><!-- .header-inner -->
	</div><!-- .cred-main-header-bar -->

	<?php
	// Output the search modal (if it is activated in the customizer).
	if ( true === $cred_enable_header_search ) :
		get_template_part( 'template-parts/modal-search' );
	endif;
	?>
</header><!-- #site-header -->

<?php get_template_part( 'template-parts/modal-menu' ); ?>
<main id="content" role="main" class="site-content">
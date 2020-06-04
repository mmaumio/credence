<?php
/**
 * Credence Custom CSS
 *
 * @package Credence
 * @since 1.0.0
 */

if ( ! function_exists( 'cred_generate_css' ) ) :

	/**
	 * Generate CSS.
	 *
	 * @param string $selector The CSS selector.
	 * @param string $style The CSS style.
	 * @param string $value The CSS value.
	 * @param string $prefix The CSS prefix.
	 * @param string $suffix The CSS suffix.
	 * @param bool   $echo Echo the styles.
	 */
	function cred_generate_css( $selector, $style, $value, $prefix = '', $suffix = '', $echo = true ) {

		$return = '';

		/*
		 * Bail early if we have no $selector elements or properties and $value.
		 */
		if ( ! $value || ! $selector ) {

			return;
		}

		$return = sprintf( '%s { %s: %s; }', $selector, $style, $prefix . $value . $suffix );

		if ( $echo ) {

			echo $return; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- We need to double check this, but for now, we want to pass PHPCS ;)

		}

		return $return;

	}
endif;

if ( ! function_exists( 'cred_get_customizer_css' ) ) :

	/**
	 * Get CSS Built from Customizer Options.
	 * Build CSS reflecting colors, fonts and other options set in the Customizer, and return them for output.
	 *
	 * @param string $type Whether to return CSS for the "front-end", "block-editor" or "classic-editor".
	 */
	function cred_get_customizer_css( $type = 'front-end' ) {

		// Get variables.
		$body              = sanitize_hex_color( cred_get_color_for_area( 'content', 'text' ) );
		$body_default      = '#000000';
		$secondary         = sanitize_hex_color( cred_get_color_for_area( 'content', 'secondary' ) );
		$secondary_default = '#6d6d6d';
		$borders           = sanitize_hex_color( cred_get_color_for_area( 'content', 'borders' ) );
		$borders_default   = '#dcd7ca';
		$accent            = sanitize_hex_color( cred_get_color_for_area( 'content', 'accent' ) );
		$accent_default    = '#cd2653';

		// Header.
		$header_footer_background         = sanitize_hex_color( cred_get_color_for_area( 'header-footer', 'background' ) );
		$header_footer_background_default = '#ffffff';

		// Background.
		$background         = sanitize_hex_color_no_hash( get_theme_mod( 'background_color' ) );

		ob_start();

		return ob_get_clean();

	}
endif;

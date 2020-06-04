<?php
/**
 * Custom icons for this theme.
 *
 * @package Credence
 * @since 1.0.0
 */

if ( ! class_exists( 'Cred_SVG_Icons' ) ) :
	/**
	 * SVG ICONS CLASS
	 * Retrieve the SVG code for the specified icon. Based on a solution in Twenty Nineteen.
	 */
	class Cred_SVG_Icons {
		/**
		 * GET SVG CODE
		 * Get the SVG code for the specified icon
		 *
		 * @param string $icon Icon name.
		 * @param string $group Icon group.
		 * @param string $color Color.
		 */
		public static function get_svg( $icon, $group = 'ui', $color = '#1A1A1B' ) {
			if ( 'ui' === $group ) :
				$arr = self::$ui_icons;
			else :
				$arr = array();
			endif;

			if ( array_key_exists( $icon, $arr ) ) :
				$repl = '<svg class="svg-icon" aria-hidden="true" role="img" focusable="false" ';
				$svg  = preg_replace( '/^<svg /', $repl, trim( $arr[ $icon ] ) ); // Add extra attributes to SVG code.
				$svg  = str_replace( '#1A1A1B', $color, $svg ); // Replace the color.
				$svg  = str_replace( '#', '%23', $svg ); // Urlencode hashes.
				$svg  = preg_replace( "/([\n\t]+)/", ' ', $svg ); // Remove newlines & tabs.
				$svg  = preg_replace( '/>\s*</', '><', $svg ); // Remove white space between SVG tags.
				return $svg;
			endif;
			return null;
		}

		/**
		 * ICON STORAGE
		 * Store the code for all SVGs in an array.
		 *
		 * @var array
		 */
		public static $ui_icons = array(
			'search'             => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24.02 24.03"><g data-name="Layer 2"><path d="M23.8 22.74l-6.38-6.38a9.8 9.8 0 002.4-6.45 9.92 9.92 0 10-3.46 7.52l6.38 6.38a.79.79 0 00.53.22.76.76 0 00.53-1.29zM1.5 9.91a8.41 8.41 0 118.41 8.41A8.42 8.42 0 011.5 9.91z" fill="#313335" data-name="Layer 1"/></g></svg>',
			'user'               => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><defs><style>.cls-1{fill:#313335}</style></defs><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><path class="cls-1" d="M11.41 11h1.18A4.42 4.42 0 0017 6.59V4.41A4.42 4.42 0 0012.59 0h-1.18A4.42 4.42 0 007 4.41v2.18A4.42 4.42 0 0011.41 11zM8.5 4.41a2.92 2.92 0 012.91-2.91h1.18a2.92 2.92 0 012.91 2.91v2.18a2.92 2.92 0 01-2.91 2.91h-1.18A2.92 2.92 0 018.5 6.59zM18.37 13H5.63A5.64 5.64 0 000 18.63v3.24A2.13 2.13 0 002.13 24h19.74A2.14 2.14 0 0024 21.87v-3.24A5.64 5.64 0 0018.37 13zm4.13 8.87a.64.64 0 01-.63.63H2.13a.63.63 0 01-.63-.63v-3.24a4.13 4.13 0 014.13-4.13h12.74a4.13 4.13 0 014.13 4.13z"/></g></g></svg>',
			'bookmark'               => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 24"><g data-name="Layer 2"><path d="M16 1.5a.5.5 0 01.5.5v19.6a.9.9 0 01-.91.9.87.87 0 01-.41-.11l-3.68-4.25a3.31 3.31 0 00-5 0l-3.68 4.25a.87.87 0 01-.41.11.9.9 0 01-.91-.9V2a.5.5 0 01.5-.5h14M16 0H2a2 2 0 00-2 2v19.6a2.4 2.4 0 003.82 1.93l3.82-4.41a1.8 1.8 0 012.72 0l3.82 4.41A2.4 2.4 0 0018 21.6V2a2 2 0 00-2-2z" fill="#313335" data-name="Layer 1"/></g></svg>',
			'clock'               => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><defs><style>.cls-1{fill:#313335}</style></defs><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><path class="cls-1" d="M12 0a12 12 0 1012 12A12 12 0 0012 0zm0 22.5A10.5 10.5 0 1122.5 12 10.51 10.51 0 0112 22.5z"/><path class="cls-1" d="M17.49 13.81l-4.74-2.33V5.69a.75.75 0 00-1.5 0v5.79a1.59 1.59 0 00.89 1.42l4.7 2.27a.78.78 0 00.33.07.75.75 0 00.32-1.43z"/></g></g></svg>',
			'edit'               => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22.95 22.97"><defs><style>.cls-1{fill:#313335}</style></defs><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><path class="cls-1" d="M20.75 8.73a.76.76 0 00-.75.75v10.87c0 .6-.35 1.12-.75 1.12h-17c-.4 0-.75-.52-.75-1.12V4.1c0-.6.35-1.13.75-1.13h10.5a.75.75 0 000-1.5H2.25A2.47 2.47 0 000 4.1v16.25A2.46 2.46 0 002.25 23h17a2.46 2.46 0 002.25-2.62V9.48a.76.76 0 00-.75-.75z"/><path class="cls-1" d="M22.81 1.57L21.39.15a.48.48 0 00-.7 0l-8.14 8.13-2.21 3.86a.34.34 0 00.47.47l3.86-2.21 8.14-8.13a.5.5 0 000-.7z"/></g></g></svg>',
			'comment'               => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><path d="M22 1.5a.5.5 0 01.5.5v19.06l-5.71-4.16-.4-.28H2a.5.5 0 01-.5-.5V2a.5.5 0 01.5-.5h20M22 0H2a2 2 0 00-2 2v14.12a2 2 0 002 2h13.91L24 24V2a2 2 0 00-2-2z" fill="#313335" data-name="Layer 1"/></g></svg>',
			'category'               => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 21"><g data-name="Layer 2"><path d="M6.64 1.5a.48.48 0 01.43.26l1.45 2.65.48.78h13a.5.5 0 01.5.5V19a.5.5 0 01-.5.5H2a.5.5 0 01-.5-.5V2a.5.5 0 01.5-.5h4.64m0-1.5H2a2 2 0 00-2 2v17a2 2 0 002 2h20a2 2 0 002-2V5.69a2 2 0 00-2-2H9.84L8.39 1a2 2 0 00-1.75-1z" fill="#313335" data-name="Layer 1"/></g></svg>',
			'chevron-down'               => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 13.5 7.5"><g data-name="Layer 2"><path d="M6.75 7.5a1.4 1.4 0 01-1-.45L.21 1.27a.75.75 0 111.08-1L6.75 6 12.21.23a.75.75 0 011.08 1L7.78 7.05a1.4 1.4 0 01-1.03.45z" fill="#313335" data-name="Layer 1"/></g></svg>',
			'cross'              => '<svg xmlns="http://www.w3.org/2000/svg"  width="22" height="22" viewBox="0 0 22 22"><g data-name="Layer 2"><path d="M13.06 12L23.77 1.28A.75.75 0 1022.71.22L12 10.94 1.28.22A.75.75 0 00.22 1.28L10.93 12 .22 22.72a.75.75 0 000 1.06.79.79 0 00.53.22.79.79 0 00.53-.22L12 13.06l10.71 10.72a.75.75 0 001.06 0 .75.75 0 000-1.06z" fill="#313335" data-name="Layer 1"/></g></svg>',
			'hamburger-menu'           => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 11.72"><defs><style>.cls-1{fill:#313335}</style></defs><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><path class="cls-1" d="M.75 1.5h14a.76.76 0 00.75-.75.76.76 0 00-.75-.75h-14A.76.76 0 000 .75a.76.76 0 00.75.75zM.75 6.61h22.5a.75.75 0 000-1.5H.75a.75.75 0 000 1.5zM23.25 10.22H.75a.75.75 0 000 1.5h22.5a.75.75 0 000-1.5z"/></g></g></svg>',
			'chevron-right'           => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 7.5 13.5"><g data-name="Layer 2"><path d="M7.5 6.75a1.4 1.4 0 01-.45 1l-5.78 5.54a.75.75 0 01-1-1.08L6 6.75.23 1.29a.75.75 0 011-1.08l5.82 5.51a1.4 1.4 0 01.45 1.03z" fill="#313335" data-name="Layer 1"/></g></svg>',
			'chevron-left'           => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 7.5 13.5"><g data-name="Layer 2"><path d="M6.75 12.75L1 7.24a.68.68 0 010-1L6.75.75" fill="none" stroke="#313335" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.5" data-name="Layer 1"/></g></svg>',
			'tag'                 => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 23.98 23.98"><defs><style>.cls-1{fill:#313335}</style></defs><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><path class="cls-1" d="M17.82 3.86a2.28 2.28 0 102.28 2.28 2.28 2.28 0 00-2.28-2.28zm0 3.05a.78.78 0 11.78-.77.78.78 0 01-.78.77z"/><path class="cls-1" d="M23.36.62A2.14 2.14 0 0021.85 0h-8.23a2.12 2.12 0 00-1.5.62L.62 12.13a2.12 2.12 0 000 3l8.23 8.23a2.12 2.12 0 003 0l11.51-11.5a2.13 2.13 0 00.64-1.51V2.12a2.12 2.12 0 00-.64-1.5zm-.88 9.73a.67.67 0 01-.18.45L10.79 22.3a.64.64 0 01-.88 0l-8.23-8.23a.63.63 0 010-.88l11.5-11.5a.64.64 0 01.45-.19h8.22a.63.63 0 01.45.18.67.67 0 01.18.44z"/></g></g></svg>'
		);
	}
endif;

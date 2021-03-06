<?php
/**
 * Displays the search icon and modal
 *
 * @package Credence
 * @since 1.0.0
 */

?>
<div class="search-modal cover-modal" data-modal-target-string=".search-modal">

	<div class="search-modal-inner modal-inner">

		<div class="section-inner">

			<?php
			get_search_form(
				array(
					'label' => __( 'Search for:', 'credence' )
				)
			);
			?>


		</div><!-- .section-inner -->

	</div><!-- .search-modal-inner -->
	<button class="toggle search-untoggle close-search-toggle fill-children-current-color" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false">
		<span class="screen-reader-text"><?php _e( 'Close search', 'credence' ); ?></span>
		<?php cred_the_theme_svg( 'cross' ); ?>
	</button><!-- .search-toggle -->

</div><!-- .menu-modal -->

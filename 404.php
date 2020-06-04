<?php
/**
 * The template for displaying the 404 template in the Credence theme.
 *
 * @package Credence
 * @since 1.0.0
 */

get_header();
?>


<div class="section-inner thin error404-content">

	<h1 class="entry-title"><?php _e( 'Page Not Found', 'credence' ); ?></h1>

	<div class="intro-text"><p><?php _e( 'The page you were looking for could not be found. It might have been removed, renamed, or did not exist in the first place.', 'credence' ); ?></p></div>

	<?php
	get_search_form(
		array(
			'label' => __( '404 not found', 'credence' )
		)
	);
	?>

</div><!-- .section-inner -->


<?php
get_footer();

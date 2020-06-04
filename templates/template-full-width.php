<?php
/**
 * Template Name: Full Width Template
 * Template Post Type: post, page
 *
 * @package Credence
 * @since 1.0
 */


get_header();
?>
<main id="site-content" role="main" class="cred-single-post-container row">
	<div class="cred-main-container cred-single-post col-lg-12">
		<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content', get_post_type() );
				endwhile;
			endif;
		?>
	</div>
</main><!-- #site-content -->	
<?php get_footer(); ?>


<?php
/**
 * The template for displaying single posts and pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Credence
 * @since 1.0.0
 */

get_header(); ?>

<div id="site-content" role="main" class="cred-single-post-container row">

	<?php 
		global $post;
		$sidebar_position = get_post_meta( $post->ID, 'cred_sidebar_status', true );
		if( empty( $sidebar_position ) || 'default' === $sidebar_position ) :
			$sidebar_position = cred_get_sidebar();
		endif;

		if ( 'sidebar_left' === $sidebar_position ) :
        	get_sidebar();
    	endif;


		if ( 'sidebar_right' === $sidebar_position || 'sidebar_left' === $sidebar_position ) :
            $center_column_width = 'col-lg-8';
        elseif ( 'sidebar_none' === $sidebar_position ) :
            $center_column_width = 'col-lg-12';
        else :
            $center_column_width = 'col-lg-12';
        endif;
	?>
		<div class="cred-main-container cred-single-post <?php echo esc_attr( $center_column_width ); ?>">
			<?php
				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content', get_post_type() );
					endwhile;
				endif;
			?>
		</div>

	<?php 
		if ( 'sidebar_right' === $sidebar_position ) :
        	get_sidebar();
    	endif;
    ?>
</div><!-- #site-content -->	
<?php get_footer(); ?>

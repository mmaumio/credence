<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Credence
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) :
	return;
endif;
global $post;
$sidebar_position = '';
$sidebar_position = cred_get_sidebar();

if( is_singular() ) :
	$sidebar_position = get_post_meta( $post->ID, 'cred_sidebar_status', true );
endif;

?>
<div class="cred-main-sidebar col-lg-4 <?php echo esc_attr( $sidebar_position ); ?>">
    <aside id="secondary" class="sidebar-widget-area">
        <?php dynamic_sidebar( 'sidebar-1' ); ?>
    </aside><!-- #secondary -->
</div>

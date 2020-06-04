<?php
/**
 * The template for displaying Related Post
 *
 * @package Credence
 * @since 1.0.0
 */

$cred_cred_enable_related_post = get_theme_mod( 'cred_enable_related_post', 1 );
$show_related_post = true;

if( $cred_cred_enable_related_post && is_single() && 'post' === get_post_type() && true === $show_related_post ) :
    $related = get_posts( 
        array( 
            'category__in' => wp_get_post_categories( $post->ID ), 
            'numberposts'  => 3, 
            'post__not_in' => array( $post->ID ) 
        ) 
    );

    if( ! empty( $related ) ) : ?>
        <div class="cred-post">
            <div class="cred-related-post-items row">
                <div class="col-lg-12">
                    <h3 class="related-post-heading"><?php _e( 'Related Posts', 'credence' ); ?></h3>
                </div>
                <?php
                foreach( $related as $post ) :
                    setup_postdata($post); 
                ?>
                    <div class="cred-single-related-post col-lg-4">
                        <?php if( has_post_thumbnail() ) : ?>
                            <div class="cred-related-post-thumb">
                                <?php the_post_thumbnail( 'cred-related-post' ); ?>
                            </div>
                        <?php endif; ?>
                        <div class="cred-related-post-content">
                            <h4 class="related-post-title">
                                <a href="<?php echo esc_url( get_the_permalink() ); ?>" rel="bookmark" title="<?php echo esc_attr( get_the_title() ); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h4>
                            <p><?php echo wp_trim_words( wp_kses_post( get_the_excerpt() ), apply_filters( 'cred_related_post_excerpt_number', 15 ) ); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php
    endif;
    wp_reset_postdata();
endif;
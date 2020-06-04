<?php
/**
 * Customizer Separator Control settings for this theme.
 *
 * @package Credence
 * @since 1.0.0
 */

if ( class_exists( 'WP_Customize_Control' ) ) :

	if ( ! class_exists( 'Cred_Heading_Custom_Control' ) ) :
		class Cred_Heading_Custom_Control extends WP_Customize_Control {

            public $type = 'heading';

            public function enqueue() {
                wp_enqueue_style( 'heading-control-css', get_template_directory_uri() . '/assets/css/heading-control.min.css' );
            }

            public function render_content() {
                ?>
                <label>
                    <div class="custom-heading">
                        <?php if ( ! empty( $this->label ) ) : ?>
                            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                        <?php endif; ?>
                    </div>
                </label>
                <?php
            }
        }
	endif;
endif;